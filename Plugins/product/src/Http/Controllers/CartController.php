<?php

namespace Modules\Plugins\Product\Http\Controllers;

use Modules\Plugins\Product\Repositories\Interfaces\CartInterface;
use Modules\Plugins\Product\Http\Requests\CartRequest;
use Modules\Plugins\Product\Tables\CartTable;
use Modules\Plugins\Product\Forms\CartForm;
use Modules\Plugins\Product\Models\Cart;

use Modules\Base\Events\BeforeEditContentEvent;
use Modules\Base\Forms\FormBuilder;
use Modules\Base\Http\Controllers\BaseController;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Base\Traits\HasDeleteManyItemsTrait;

use Modules\Plugins\Product\Forms\ProductForm;
use Modules\Plugins\Product\Http\Requests\ProductRequest;
use Modules\Plugins\Product\Models\Product;
use Modules\Plugins\Product\Tables\ProductTable;
use Modules\Plugins\Product\Repositories\Interfaces\ProductInterface;

use Modules\Plugins\Product\Repositories\Interfaces\ProCategoryInterface;
use Modules\Plugins\Product\Repositories\Interfaces\OrderstatusInterface;
use Modules\Plugins\Product\Repositories\Interfaces\FeaturesInterface;


use Modules\Plugins\Product\Repositories\Interfaces\ProTagInterface;
use Modules\Plugins\Product\Services\StoreProCategoryService;
use Modules\Plugins\Product\Services\StoreProTagService;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Base\Events\CreatedContentEvent;
use Modules\Base\Events\DeletedContentEvent;
use Modules\Base\Events\UpdatedContentEvent;
use Illuminate\View\View;
use Throwable;
use DB;

class CartController extends BaseController
{
    /**
     * @var CartInterface
     */
    protected $cartRepository;

    protected $orderstatusRepository;
    
    /**
     * CartController constructor.
     * @param CartInterface $cartRepository
     */
    public function __construct(
        CartInterface $cartRepository,
        OrderstatusInterface $orderstatusRepository)
    {
        $this->cartRepository = $cartRepository;
        $this->orderstatusRepository = $orderstatusRepository;
    }

    /**
     * @param CartTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(CartTable $table)
    {
        page_title()->setTitle(trans('modules.plugins.product::cart.name'));

        return $table->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('modules.plugins.product::cart.create'));

        return $formBuilder->create(CartForm::class)->renderForm();
    }

    /**
     * Create new item
     *
     * @param CartRequest $request
     * @return BaseHttpResponse
     */
    public function store(CartRequest $request, BaseHttpResponse $response)
    {
        //$cart = $this->cartRepository->createOrUpdate($request->input());

        $cart = $this->cartRepository->createOrUpdate(array_merge($request->input(), [
            'author_id' => Auth::user()->getKey(),
        ]));

        if ($cart) {
            $cart->orderstatus()->sync($request->input('orderstatus', []));
            $cart->shipping()->sync($request->input('shipping', []));  
            $cart->payment()->sync($request->input('payment', []));
        }

        event(new CreatedContentEvent(CART_MODULE_SCREEN_NAME, $request, $cart));

        return $response
            ->setPreviousUrl(route('cart.index'))
            ->setNextUrl(route('cart.edit', $cart->id))
            ->setMessage(trans('modules.base::notices.create_success_message'));
    }

    /**
     * Show edit form
     *
     * @param $id
     * @param Request $request
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function edit($id, FormBuilder $formBuilder, Request $request)
    {
        $cart = $this->cartRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $cart));

        page_title()->setTitle(trans('modules.plugins.product::cart.edit') . ' "' . $cart->name . '"');

        return $formBuilder->create(CartForm::class, ['model' => $cart])->renderForm();
    }

    /**
     * @param $id
     * @param CartRequest $request
     * @return BaseHttpResponse
     */
    public function update($id, CartRequest $request, BaseHttpResponse $response)
    {
        $cart = $this->cartRepository->findOrFail($id);

        $cart->fill($request->input());

        $this->cartRepository->createOrUpdate($cart);

        $cart->orderstatus()->sync($request->input('orderstatus', []));
       $cart->shipping()->sync($request->input('shipping', []));
        $cart->payment()->sync($request->input('payment', []));

        event(new UpdatedContentEvent(CART_MODULE_SCREEN_NAME, $request, $cart));

        return $response
            ->setPreviousUrl(route('cart.index'))
            ->setMessage(trans('modules.base::notices.update_success_message'));
    }

    /**
     * @param $id
     * @param Request $request
     * @return BaseHttpResponse
     */
    public function destroy(Request $request, $id, BaseHttpResponse $response)
    {
        try {
            $cart = $this->cartRepository->findOrFail($id);

            $this->cartRepository->delete($cart);

            event(new DeletedContentEvent(CART_MODULE_SCREEN_NAME, $request, $cart));

            return $response->setMessage(trans('modules.base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage(trans('modules.base::notices.cannot_delete'));
        }
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws Exception
     */
    public function deletes(Request $request, BaseHttpResponse $response)
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return $response
                ->setError()
                ->setMessage(trans('modules.base::notices.no_select'));
        }

        foreach ($ids as $id) {
            $cart = $this->cartRepository->findOrFail($id);
            $this->cartRepository->delete($cart);
            event(new DeletedContentEvent(CART_MODULE_SCREEN_NAME, $request, $cart));
        }

        return $response->setMessage(trans('modules.base::notices.delete_success_message'));
    }


    /*public function getInfoProduct()
    {
        $id = request('id');
        $sku = request('sku');
        if ($id) {
            $product = (new Product)->getDetail($id);
        } else {
            $product = (new Product)->getDetail('sku', $type = 'sku');
        }
        $arrayReturn = $product->toArray();
        $arrayReturn['renderAttDetails'] = $product->renderAttributeDetailsAdmin();
        $arrayReturn['price_final'] = $product->getFinalPrice();
        return response()->json($arrayReturn);
    }*/

 
    public function search(Request $request)
    {
        if ($request->ajax()) {
            $id = request('id');
            $sku = request('sku');

            $output = '';
            //$products = DB::table('products')->where('name', 'LIKE', '%' . $request->search . '%')->get();

            $products = DB::table('products')->where('id', '=', $id)->get();

            if ($products) {
                foreach ($products as $key => $product) {
                   
                    //$output = $product->sizes;
                    
                    $output =[
                        'id' => $product->id,
                        'name' => $product->name,
                        'pricecost' => $product->pricecost,
                        'pricesell' => $product->pricesell,
                        'pricesale' => $product->pricesale,
                        'sizes' => $product->sizes,
                        'images' => $product->images,

                    ];

                }
            }
            return Response($output);
        }
    }

    public function postAddItem(Request $request)
    {

    $price =  $request->input('add_price');
    $qty =  $request->input('add_qty');
    $carts_amound = $price*$qty; 
    
    $carts_id =  $request->input('carts_id');
    $product_id = $request->input('product_id');

    echo $price;

    /*if($carts_id !='' && $product_id !=''){
      $data = array(
            'carts_id'=>$carts_id,
            'product_id'=>$product_id,
            //'carts_amound'=>$carts_amound,
        );
      echo $carts_id;
      // Call insertData() method of Page Model
      $value = Cart::insertData($data);
      if($value){
        echo $value;
      }else{
        echo 0;
      }

    }else{
       echo 'Fill all fields.';
    }
    exit; */

    }

}
