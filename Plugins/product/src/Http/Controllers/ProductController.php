<?php

namespace Modules\Plugins\Product\Http\Controllers;

use Modules\Base\Events\BeforeEditContentEvent;
use Modules\Base\Forms\FormBuilder;
use Modules\Base\Http\Controllers\BaseController;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Base\Traits\HasDeleteManyItemsTrait;
use Modules\Plugins\Product\Forms\ProductForm;
use Modules\Plugins\Product\Http\Requests\ProductRequest;
use Modules\Plugins\Product\Models\Product;
use Modules\Plugins\Product\Repositories\Interfaces\ProCategoryInterface;
use Modules\Plugins\Product\Repositories\Interfaces\FeaturesInterface;
use Modules\Plugins\Product\Repositories\Interfaces\ProductInterface;
use Modules\Plugins\Product\Tables\ProductTable;
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

class ProductController extends BaseController
{

    use HasDeleteManyItemsTrait;

    /**
     * @var ProductInterface
     */
    protected $productRepository;


    protected $featuresRepository;
    /**
     * @var TagInterface
     */
    protected $tagRepository;

    /**
     * @var CategoryInterface
     */
    protected $procategoryRepository;

    /**
     * @param ProductInterface $productRepository
     * @param TagInterface $tagRepository
     * @param CategoryInterface $categoryRepository
     */
    public function __construct(
        ProductInterface $productRepository,
        ProTagInterface $protagRepository,
        ProCategoryInterface $procategoryRepository,
        FeaturesInterface $featuresRepository
    ) {
        $this->productRepository = $productRepository;
        $this->protagRepository = $protagRepository;
        $this->procategoryRepository = $procategoryRepository;
        $this->featuresRepository = $featuresRepository;
    }

    /**
     * @param ProductTable $dataTable
     * @return Factory|View
     * @throws Throwable
     */
    public function index(ProductTable $dataTable)
    {
        page_title()->setTitle(trans('modules.plugins.product::products.menu_name'));

        return $dataTable->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('modules.plugins.product::products.create'));

        return $formBuilder->create(ProductForm::class)->renderForm();
    }

    /**
     * @param ProductRequest $request
     * @param StoreTagService $tagService
     * @param StoreCategoryService $categoryService
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function store(
        ProductRequest $request,
        StoreProTagService $protagService,
        StoreProCategoryService $procategoryService,
        BaseHttpResponse $response
    ) {


        /**
         * @var Product $product
         */
        $request->merge(['images' => json_encode($request->input('images', []))]);
        
        $request->merge(['colors' => json_encode($request->input('colors', []))]);

        $request->merge(['sizes' => json_encode($request->input('sizes', []))]);

        $product = $this->productRepository->createOrUpdate(array_merge($request->input(), [
            'author_id' => Auth::user()->getKey(),
        ]));

        if ($product) {
            $product->features()->sync($request->input('features', []));
        }

        event(new CreatedContentEvent(PRODUCT_MODULE_SCREEN_NAME, $request, $product));



        $protagService->execute($request, $product);

        $procategoryService->execute($request, $product);

        return $response
            ->setPreviousUrl(route('products.index'))
            ->setNextUrl(route('products.edit', $product->id))
            ->setMessage(trans('modules.base::notices.create_success_message'));
    }

    /**
     * @param int $id
     * @param FormBuilder $formBuilder
     * @param Request $request
     * @return string
     */
    public function edit($id, FormBuilder $formBuilder, Request $request)
    {
        $product = $this->productRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $product));

        page_title()->setTitle(trans('modules.plugins.product::products.edit') . ' "' . $product->name . '"');

        return $formBuilder->create(ProductForm::class, ['model' => $product])->renderForm();
    }

    /**
     * @param int $id
     * @param ProductRequest $request
     * @param StoreTagService $tagService
     * @param StoreCategoryService $categoryService
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function update(
        $id,
        ProductRequest $request,
        StoreProTagService $protagService,
        StoreProCategoryService $procategoryService,
        BaseHttpResponse $response
    ) {

        $product = $this->productRepository->findOrFail($id);

        $request->merge(['images' => json_encode($request->input('images', []))]);

        $request->merge(['colors' => json_encode($request->input('colors', []))]);

        $request->merge(['sizes' => json_encode($request->input('sizes', []))]);

        $product->fill($request->input());

        $this->productRepository->createOrUpdate($product);

        $product->features()->sync($request->input('features', []));

        event(new UpdatedContentEvent(PRODUCT_MODULE_SCREEN_NAME, $request, $product));

        $protagService->execute($request, $product);

        $procategoryService->execute($request, $product);

        return $response
            ->setPreviousUrl(route('products.index'))
            ->setMessage(trans('modules.base::notices.update_success_message'));

    }

    /**
     * @param int $id
     * @param Request $request
     * @return BaseHttpResponse
     */
    public function destroy($id, Request $request, BaseHttpResponse $response)
    {
        try {
            $product = $this->productRepository->findOrFail($id);
            $this->productRepository->delete($product);

            event(new DeletedContentEvent(PRODUCT_MODULE_SCREEN_NAME, $request, $product));

            return $response
                ->setMessage(trans('modules.base::notices.delete_success_message'));
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
        return $this->executeDeleteItems($request, $response, $this->productRepository, PRODUCT_MODULE_SCREEN_NAME);
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws Throwable
     */
    public function getWidgetRecentProducts(Request $request, BaseHttpResponse $response)
    {
        $limit = $request->input('paginate', 10);
        $products = $this->productRepository->getModel()
            ->orderBy('products.created_at', 'desc')
            ->paginate($limit);

        return $response
            ->setData(view('modules.plugins.product::products.widgets.products', compact('products', 'limit'))->render());
    }

}
