<?php

namespace Modules\Plugins\Product\Http\Controllers;

use Modules\Base\Events\BeforeEditContentEvent;
use Modules\Plugins\Product\Http\Requests\FeaturesRequest;
use Modules\Plugins\Product\Repositories\Interfaces\FeaturesInterface;
use Modules\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Modules\Plugins\Product\Tables\FeaturesTable;
use Modules\Base\Events\CreatedContentEvent;
use Modules\Base\Events\DeletedContentEvent;
use Modules\Base\Events\UpdatedContentEvent;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Plugins\Product\Forms\FeaturesForm;
use Modules\Base\Forms\FormBuilder;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;
use Throwable;

class FeaturesController extends BaseController
{
    /**
     * @var FeaturesInterface
     */
    protected $featuresRepository;

    /**
     * FeaturesController constructor.
     * @param FeaturesInterface $featuresRepository
     */
    public function __construct(FeaturesInterface $featuresRepository)
    {
        $this->featuresRepository = $featuresRepository;
    }

    /**
     * @param FeaturesTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(FeaturesTable $table)
    {
        page_title()->setTitle(trans('modules.plugins.product::features.name'));

        return $table->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('modules.plugins.product::features.create'));

        return $formBuilder->create(FeaturesForm::class)->renderForm();
    }

    /**
     * Create new item
     *
     * @param FeaturesRequest $request
     * @return BaseHttpResponse
     */
    public function store(FeaturesRequest $request, BaseHttpResponse $response)
    {
        $features = $this->featuresRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(FEATURES_MODULE_SCREEN_NAME, $request, $features));

        return $response
            ->setPreviousUrl(route('features.index'))
            ->setNextUrl(route('features.edit', $features->id))
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
        $features = $this->featuresRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $features));

        page_title()->setTitle(trans('modules.plugins.product::features.edit') . ' "' . $features->name . '"');

        return $formBuilder->create(FeaturesForm::class, ['model' => $features])->renderForm();
    }

    /**
     * @param $id
     * @param FeaturesRequest $request
     * @return BaseHttpResponse
     */
    public function update($id, FeaturesRequest $request, BaseHttpResponse $response)
    {
        $features = $this->featuresRepository->findOrFail($id);

        $features->fill($request->input());

        $this->featuresRepository->createOrUpdate($features);

        event(new UpdatedContentEvent(FEATURES_MODULE_SCREEN_NAME, $request, $features));

        return $response
            ->setPreviousUrl(route('features.index'))
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
            $features = $this->featuresRepository->findOrFail($id);

            $this->featuresRepository->delete($features);

            event(new DeletedContentEvent(FEATURES_MODULE_SCREEN_NAME, $request, $features));

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
            $features = $this->featuresRepository->findOrFail($id);
            $this->featuresRepository->delete($features);
            event(new DeletedContentEvent(FEATURES_MODULE_SCREEN_NAME, $request, $features));
        }

        return $response->setMessage(trans('modules.base::notices.delete_success_message'));
    }
}
