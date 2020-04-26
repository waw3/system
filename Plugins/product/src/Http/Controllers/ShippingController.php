<?php

namespace Modules\Plugins\Product\Http\Controllers;

use Modules\Base\Events\BeforeEditContentEvent;
use Modules\Plugins\Product\Http\Requests\ShippingRequest;
use Modules\Plugins\Product\Repositories\Interfaces\ShippingInterface;
use Modules\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Exception;
use Modules\Plugins\Product\Tables\ShippingTable;
use Modules\Base\Events\CreatedContentEvent;
use Modules\Base\Events\DeletedContentEvent;
use Modules\Base\Events\UpdatedContentEvent;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Plugins\Product\Forms\ShippingForm;
use Modules\Base\Forms\FormBuilder;

class ShippingController extends BaseController
{
    /**
     * @var ShippingInterface
     */
    protected $shippingRepository;

    /**
     * ShippingController constructor.
     * @param ShippingInterface $shippingRepository
     */
    public function __construct(ShippingInterface $shippingRepository)
    {
        $this->shippingRepository = $shippingRepository;
    }

    /**
     * @param ShippingTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(ShippingTable $table)
    {
        page_title()->setTitle(trans('modules.plugins.product::shipping.name'));

        return $table->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('modules.plugins.product::shipping.create'));

        return $formBuilder->create(ShippingForm::class)->renderForm();
    }

    /**
     * Create new item
     *
     * @param ShippingRequest $request
     * @return BaseHttpResponse
     */
    public function store(ShippingRequest $request, BaseHttpResponse $response)
    {
        $shipping = $this->shippingRepository->createOrUpdate($request->input());

       
        event(new CreatedContentEvent(SHIPPING_MODULE_SCREEN_NAME, $request, $shipping));

        return $response
            ->setPreviousUrl(route('shipping.index'))
            ->setNextUrl(route('shipping.edit', $shipping->id))
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
        $shipping = $this->shippingRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $shipping));

        page_title()->setTitle(trans('modules.plugins.product::shipping.edit') . ' "' . $shipping->name . '"');

        return $formBuilder->create(ShippingForm::class, ['model' => $shipping])->renderForm();
    }

    /**
     * @param $id
     * @param ShippingRequest $request
     * @return BaseHttpResponse
     */
    public function update($id, ShippingRequest $request, BaseHttpResponse $response)
    {
        $shipping = $this->shippingRepository->findOrFail($id);

        $shipping->fill($request->input());

        $this->shippingRepository->createOrUpdate($shipping);

        event(new UpdatedContentEvent(SHIPPING_MODULE_SCREEN_NAME, $request, $shipping));

        return $response
            ->setPreviousUrl(route('shipping.index'))
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
            $shipping = $this->shippingRepository->findOrFail($id);

            $this->shippingRepository->delete($shipping);

            event(new DeletedContentEvent(SHIPPING_MODULE_SCREEN_NAME, $request, $shipping));

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
            $shipping = $this->shippingRepository->findOrFail($id);
            $this->shippingRepository->delete($shipping);
            event(new DeletedContentEvent(SHIPPING_MODULE_SCREEN_NAME, $request, $shipping));
        }

        return $response->setMessage(trans('modules.base::notices.delete_success_message'));
    }
}
