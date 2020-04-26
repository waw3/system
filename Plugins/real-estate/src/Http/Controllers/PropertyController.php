<?php

namespace Modules\Plugins\RealEstate\Http\Controllers;

use Modules\Base\Events\BeforeEditContentEvent;
use Modules\Base\Events\CreatedContentEvent;
use Modules\Base\Events\DeletedContentEvent;
use Modules\Base\Events\UpdatedContentEvent;
use Modules\Base\Forms\FormBuilder;
use Modules\Base\Http\Controllers\BaseController;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Plugins\RealEstate\Forms\PropertyForm;
use Modules\Plugins\RealEstate\Http\Requests\PropertyRequest;
use Modules\Plugins\RealEstate\Repositories\Interfaces\ProjectInterface;
use Modules\Plugins\RealEstate\Repositories\Interfaces\FeatureInterface;
use Modules\Plugins\RealEstate\Repositories\Interfaces\PropertyInterface;
use Modules\Plugins\RealEstate\Tables\PropertyTable;
use Modules\Plugins\Vendor\Models\Vendor;
use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Throwable;

class PropertyController extends BaseController
{
    /**
     * @var PropertyInterface $propertyRepository
     */
    protected $propertyRepository;

    /**
     * @var ProjectInterface
     */
    protected $projectRepository;

    /**
     * @var FeatureInterface
     */
    protected $featureRepository;

    /**
     * PropertyController constructor.
     * @param PropertyInterface $propertyRepository
     * @param ProjectInterface $projectRepository
     * @param FeatureInterface $featureRepository
     */
    public function __construct(
        PropertyInterface $propertyRepository,
        ProjectInterface $projectRepository,
        FeatureInterface $featureRepository
    ) {
        $this->propertyRepository = $propertyRepository;
        $this->projectRepository = $projectRepository;
        $this->featureRepository = $featureRepository;
    }

    /**
     * @param PropertyTable $dataTable
     * @return JsonResponse|View
     * @throws Throwable
     */
    public function index(PropertyTable $dataTable)
    {
        page_title()->setTitle(trans('modules.plugins.real-estate::property.name'));

        return $dataTable->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('modules.plugins.real-estate::property.create'));

        return $formBuilder->create(PropertyForm::class)->renderForm();
    }

    /**
     * @param PropertyRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws FileNotFoundException
     */
    public function store(PropertyRequest $request, BaseHttpResponse $response)
    {
        if (is_plugin_active('vendor')) {
            $request->merge(['author_type' => Vendor::class]);
        }

        $request->merge([
            'expire_date' => now()->addDays(45),
            'images' => json_encode($request->input('images', [])),
        ]);

        $property = $this->propertyRepository->getModel();
        $property = $property->fill($request->input());
        $property->moderation_status = $request->input('moderation_status');
        $property->save();

        event(new CreatedContentEvent(PROPERTY_MODULE_SCREEN_NAME, $request, $property));

        if ($property) {
            $property->features()->sync($request->input('features', []));
        }

        return $response
            ->setPreviousUrl(route('property.index'))
            ->setNextUrl(route('property.edit', $property->id))
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
        $property = $this->propertyRepository->findOrFail($id, ['features', 'author']);
        page_title()->setTitle(trans('modules.plugins.real-estate::property.edit') . ' "' . $property->name . '"');

        event(new BeforeEditContentEvent($request, $property));

        return $formBuilder->create(PropertyForm::class, ['model' => $property])->renderForm();
    }

    /**
     * @param int $id
     * @param PropertyRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws FileNotFoundException
     */
    public function update($id, PropertyRequest $request, BaseHttpResponse $response)
    {
        $property = $this->propertyRepository->findOrFail($id);
        $property->fill($request->except(['expire_date']));

        if (is_plugin_active('vendor')) {
            $property->author_type = Vendor::class;
        }

        $property->images = json_encode($request->input('images', []));
        $property->moderation_status = $request->input('moderation_status');

        $this->propertyRepository->createOrUpdate($property);

        event(new UpdatedContentEvent(PROPERTY_MODULE_SCREEN_NAME, $request, $property));

        $property->features()->sync($request->input('features', []));

        return $response
            ->setPreviousUrl(route('property.index'))
            ->setNextUrl(route('property.edit', $property->id))
            ->setMessage(trans('modules.base::notices.create_success_message'));
    }

    /**
     * @param int $id
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function destroy($id, BaseHttpResponse $response)
    {
        try {
            $property = $this->propertyRepository->findOrFail($id);
            $property->features()->detach();
            $this->propertyRepository->delete($property);

            event(new DeletedContentEvent(PROPERTY_MODULE_SCREEN_NAME, request(), $property));

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
            $property = $this->propertyRepository->findOrFail($id);
            $property->features()->detach();
            $this->propertyRepository->delete($property);

            event(new DeletedContentEvent(PROPERTY_MODULE_SCREEN_NAME, $request, $property));
        }

        return $response->setMessage(trans('modules.base::notices.delete_success_message'));
    }
}
