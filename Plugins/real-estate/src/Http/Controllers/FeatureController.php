<?php

namespace Modules\Plugins\RealEstate\Http\Controllers;

use Modules\Base\Events\BeforeEditContentEvent;
use Modules\Base\Events\CreatedContentEvent;
use Modules\Base\Events\DeletedContentEvent;
use Modules\Base\Events\UpdatedContentEvent;
use Modules\Base\Forms\FormBuilder;
use Modules\Base\Http\Controllers\BaseController;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Plugins\RealEstate\Forms\FeatureForm;
use Modules\Plugins\RealEstate\Http\Requests\FeatureRequest;
use Modules\Plugins\RealEstate\Repositories\Interfaces\FeatureInterface;
use Modules\Plugins\RealEstate\Tables\FeatureTable;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Throwable;

class FeatureController extends BaseController
{
    /**
     * @var FeatureInterface
     */
    protected $featureRepository;

    /**
     * FeatureController constructor.
     * @param FeatureInterface $featureRepository
     */
    public function __construct(FeatureInterface $featureRepository)
    {
        $this->featureRepository = $featureRepository;
    }


    /**
     * @param FeatureTable $dataTable
     * @return JsonResponse|View
     * @throws Throwable
     */
    public function index(FeatureTable $dataTable)
    {
        page_title()->setTitle(trans('modules.plugins.real-estate::feature.name'));

        return $dataTable->renderTable();
    }

    /**
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        return $formBuilder->create(FeatureForm::class)->renderForm();
    }

    /**
     * @param FeatureRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function store(FeatureRequest $request, BaseHttpResponse $response)
    {
        $feature = $this->featureRepository->create($request->all());

        event(new CreatedContentEvent(FEATURE_MODULE_SCREEN_NAME, $request, $feature));

        return $response
            ->setPreviousUrl(route('property_feature.index'))
            ->setNextUrl(route('property_feature.edit', $feature->id))
            ->setMessage(trans('modules.base::notices.create_success_message'));
    }

    /**
     * @param int $id
     * @param Request $request
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function edit($id, Request $request, FormBuilder $formBuilder)
    {
        $feature = $this->featureRepository->findOrFail($id);
        page_title()->setTitle(trans('modules.plugins.real-estate::feature.edit') . ' "' . $feature->name . '"');

        event(new BeforeEditContentEvent($request, $feature));

        return $formBuilder->create(FeatureForm::class, ['model' => $feature])->renderForm();
    }

    /**
     * @param int $id
     * @param FeatureRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function update($id, FeatureRequest $request, BaseHttpResponse $response)
    {
        $feature = $this->featureRepository->findOrFail($id);

        $feature->fill($request->input());
        $this->featureRepository->createOrUpdate($feature);

        event(new UpdatedContentEvent(FEATURE_MODULE_SCREEN_NAME, $request, $feature));

        return $response
            ->setPreviousUrl(route('property_feature.index'))
            ->setMessage(trans('modules.base::notices.update_success_message'));
    }

    /**
     * @param Request $request
     * @param int $id
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function destroy($id, Request $request, BaseHttpResponse $response)
    {
        try {
            $feature = $this->featureRepository->findOrFail($id);
            $this->featureRepository->delete($feature);

            event(new DeletedContentEvent(FEATURE_MODULE_SCREEN_NAME, $request, $feature));

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
            $feature = $this->featureRepository->findOrFail($id);
            $this->featureRepository->delete($feature);

            event(new DeletedContentEvent(FEATURE_MODULE_SCREEN_NAME, $request, $feature));
        }

        return $response->setMessage(trans('modules.base::notices.delete_success_message'));
    }
}
