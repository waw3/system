<?php

namespace Modules\Plugins\Product\Http\Controllers;

use Modules\Base\Events\BeforeEditContentEvent;
use Modules\Plugins\Product\Http\Requests\OrderstatusRequest;
use Modules\Plugins\Product\Repositories\Interfaces\OrderstatusInterface;
use Modules\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Exception;
use Modules\Plugins\Product\Tables\OrderstatusTable;
use Modules\Base\Events\CreatedContentEvent;
use Modules\Base\Events\DeletedContentEvent;
use Modules\Base\Events\UpdatedContentEvent;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Plugins\Product\Forms\OrderstatusForm;
use Modules\Base\Forms\FormBuilder;

class OrderstatusController extends BaseController
{
    /**
     * @var OrderstatusInterface
     */
    protected $orderstatusRepository;

    /**
     * OrderstatusController constructor.
     * @param OrderstatusInterface $orderstatusRepository
     */
    public function __construct(OrderstatusInterface $orderstatusRepository)
    {
        $this->orderstatusRepository = $orderstatusRepository;
    }

    /**
     * @param OrderstatusTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(OrderstatusTable $table)
    {
        page_title()->setTitle(trans('modules.plugins.product::orderstatus.name'));

        return $table->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('modules.plugins.product::orderstatus.create'));

        return $formBuilder->create(OrderstatusForm::class)->renderForm();
    }

    /**
     * Create new item
     *
     * @param OrderstatusRequest $request
     * @return BaseHttpResponse
     */
    public function store(OrderstatusRequest $request, BaseHttpResponse $response)
    {
        $orderstatus = $this->orderstatusRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(ORDERSTATUS_MODULE_SCREEN_NAME, $request, $orderstatus));

        return $response
            ->setPreviousUrl(route('orderstatus.index'))
            ->setNextUrl(route('orderstatus.edit', $orderstatus->id))
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
        $orderstatus = $this->orderstatusRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $orderstatus));

        page_title()->setTitle(trans('modules.plugins.product::orderstatus.edit') . ' "' . $orderstatus->name . '"');

        return $formBuilder->create(OrderstatusForm::class, ['model' => $orderstatus])->renderForm();
    }

    /**
     * @param $id
     * @param OrderstatusRequest $request
     * @return BaseHttpResponse
     */
    public function update($id, OrderstatusRequest $request, BaseHttpResponse $response)
    {
        $orderstatus = $this->orderstatusRepository->findOrFail($id);

        $orderstatus->fill($request->input());

        $this->orderstatusRepository->createOrUpdate($orderstatus);

        event(new UpdatedContentEvent(ORDERSTATUS_MODULE_SCREEN_NAME, $request, $orderstatus));

        return $response
            ->setPreviousUrl(route('orderstatus.index'))
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
            $orderstatus = $this->orderstatusRepository->findOrFail($id);

            $this->orderstatusRepository->delete($orderstatus);

            event(new DeletedContentEvent(ORDERSTATUS_MODULE_SCREEN_NAME, $request, $orderstatus));

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
            $orderstatus = $this->orderstatusRepository->findOrFail($id);
            $this->orderstatusRepository->delete($orderstatus);
            event(new DeletedContentEvent(ORDERSTATUS_MODULE_SCREEN_NAME, $request, $orderstatus));
        }

        return $response->setMessage(trans('modules.base::notices.delete_success_message'));
    }
}
