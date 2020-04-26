<?php

namespace Modules\Plugins\Product\Http\Controllers;

use Modules\Base\Events\BeforeEditContentEvent;
use Modules\Plugins\Product\Http\Requests\StoreRequest;
use Modules\Plugins\Product\Repositories\Interfaces\StoreInterface;
use Modules\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Exception;
use Modules\Plugins\Product\Tables\StoreTable;
use Modules\Base\Events\CreatedContentEvent;
use Modules\Base\Events\DeletedContentEvent;
use Modules\Base\Events\UpdatedContentEvent;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Plugins\Product\Forms\StoreForm;
use Modules\Base\Forms\FormBuilder;

class StoreController extends BaseController
{
    /**
     * @var StoreInterface
     */
    protected $storeRepository;

    /**
     * StoreController constructor.
     * @param StoreInterface $storeRepository
     */
    public function __construct(StoreInterface $storeRepository)
    {
        $this->storeRepository = $storeRepository;
    }

    /**
     * @param StoreTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(StoreTable $table)
    {
        page_title()->setTitle(trans('modules.plugins.product::store.name'));

        return $table->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('modules.plugins.product::store.create'));

        return $formBuilder->create(StoreForm::class)->renderForm();
    }

    /**
     * Create new item
     *
     * @param StoreRequest $request
     * @return BaseHttpResponse
     */
    public function store(StoreRequest $request, BaseHttpResponse $response)
    {
        $store = $this->storeRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(STORE_MODULE_SCREEN_NAME, $request, $store));

        return $response
            ->setPreviousUrl(route('store.index'))
            ->setNextUrl(route('store.edit', $store->id))
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
        $store = $this->storeRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $store));

        page_title()->setTitle(trans('modules.plugins.product::store.edit') . ' "' . $store->name . '"');

        return $formBuilder->create(StoreForm::class, ['model' => $store])->renderForm();
    }

    /**
     * @param $id
     * @param StoreRequest $request
     * @return BaseHttpResponse
     */
    public function update($id, StoreRequest $request, BaseHttpResponse $response)
    {
        $store = $this->storeRepository->findOrFail($id);

        $store->fill($request->input());

        $this->storeRepository->createOrUpdate($store);

        event(new UpdatedContentEvent(STORE_MODULE_SCREEN_NAME, $request, $store));

        return $response
            ->setPreviousUrl(route('store.index'))
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
            $store = $this->storeRepository->findOrFail($id);

            $this->storeRepository->delete($store);

            event(new DeletedContentEvent(STORE_MODULE_SCREEN_NAME, $request, $store));

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
            $store = $this->storeRepository->findOrFail($id);
            $this->storeRepository->delete($store);
            event(new DeletedContentEvent(STORE_MODULE_SCREEN_NAME, $request, $store));
        }

        return $response->setMessage(trans('modules.base::notices.delete_success_message'));
    }
}
