<?php

namespace Modules\Plugins\RealEstate\Http\Controllers;

use Modules\Base\Events\BeforeEditContentEvent;
use Modules\Base\Events\CreatedContentEvent;
use Modules\Base\Events\DeletedContentEvent;
use Modules\Base\Events\UpdatedContentEvent;
use Modules\Base\Forms\FormBuilder;
use Modules\Base\Http\Controllers\BaseController;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Plugins\RealEstate\Forms\ProjectForm;
use Modules\Plugins\RealEstate\Http\Requests\ProjectRequest;
use Modules\Plugins\RealEstate\Repositories\Interfaces\FeatureInterface;
use Modules\Plugins\RealEstate\Repositories\Interfaces\ProjectInterface;
use Modules\Plugins\RealEstate\Tables\ProjectTable;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Throwable;

class ProjectController extends BaseController
{
    /**
     * @var ProjectInterface
     */
    protected $projectRepository;

    /**
     * @var FeatureInterface
     */
    protected $featureRepository;

    /**
     * ProjectController constructor.
     * @param ProjectInterface $projectRepository
     * @param FeatureInterface $featureRepository
     */
    public function __construct(ProjectInterface $projectRepository, FeatureInterface $featureRepository)
    {
        $this->projectRepository = $projectRepository;
        $this->featureRepository = $featureRepository;
    }

    /**
     * @param ProjectTable $dataTable
     * @return JsonResponse|View
     * @throws Throwable
     */
    public function index(ProjectTable $dataTable)
    {
        page_title()->setTitle(trans('modules.plugins.real-estate::project.name'));

        return $dataTable->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('modules.plugins.real-estate::project.create'));

        return $formBuilder->create(ProjectForm::class)->renderForm();
    }

    /**
     * @param ProjectRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function store(ProjectRequest $request, BaseHttpResponse $response)
    {
        $request->merge(['images' => json_encode($request->input('images', []))]);

        $project = $this->projectRepository->create($request->input());

        if ($project) {
            $project->features()->sync($request->input('features', []));
        }

        event(new CreatedContentEvent(PROJECT_MODULE_SCREEN_NAME, $request, $project));

        return $response
            ->setPreviousUrl(route('project.index'))
            ->setNextUrl(route('project.edit', $project->id))
            ->setMessage(trans('modules.base::notices.create_success_message'));
    }

    /**
     * @param $id
     * @param Request $request
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function edit($id, Request $request, FormBuilder $formBuilder)
    {
        $project = $this->projectRepository->findOrFail($id);

        page_title()->setTitle(trans('modules.plugins.real-estate::project.edit') . ' "' . $project->name . '"');

        event(new BeforeEditContentEvent($request, $project));

        return $formBuilder->create(ProjectForm::class, ['model' => $project])->renderForm();
    }

    /**
     * @param ProjectRequest $request
     * @param int $id
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function update(ProjectRequest $request, $id, BaseHttpResponse $response)
    {
        $project = $this->projectRepository->findOrFail($id);

        $request->merge(['images' => json_encode($request->input('images', []))]);

        $project->fill($request->input());

        $this->projectRepository->createOrUpdate($project);

        $project->features()->sync($request->input('features', []));

        event(new UpdatedContentEvent(PROJECT_MODULE_SCREEN_NAME, $request, $project));

        return $response
            ->setPreviousUrl(route('project.index'))
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
            $project = $this->projectRepository->findOrFail($id);
            $this->projectRepository->delete($project);

            event(new DeletedContentEvent(PROJECT_MODULE_SCREEN_NAME, $request, $project));

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
            $project = $this->projectRepository->findOrFail($id);
            $this->projectRepository->delete($project);

            event(new DeletedContentEvent(PROJECT_MODULE_SCREEN_NAME, $request, $project));
        }

        return $response->setMessage(trans('modules.base::notices.delete_success_message'));
    }
}
