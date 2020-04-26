<?php

namespace Modules\Plugins\Vendor\Http\Controllers;

use Modules\Base\Events\BeforeEditContentEvent;
use Modules\Plugins\Vendor\Http\Requests\PackageRequest;
use Modules\Plugins\Vendor\Repositories\Interfaces\PackageInterface;
use Modules\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Exception;
use Modules\Plugins\Vendor\Tables\PackageTable;
use Modules\Base\Events\CreatedContentEvent;
use Modules\Base\Events\DeletedContentEvent;
use Modules\Base\Events\UpdatedContentEvent;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Plugins\Vendor\Forms\PackageForm;
use Modules\Base\Forms\FormBuilder;

class PackageController extends BaseController
{
    /**
     * @var PackageInterface
     */
    protected $packageRepository;

    /**
     * PackageController constructor.
     * @param PackageInterface $packageRepository
     */
    public function __construct(PackageInterface $packageRepository)
    {
        $this->packageRepository = $packageRepository;
    }

    /**
     * @param PackageTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(PackageTable $table)
    {

        page_title()->setTitle(trans('modules.plugins.vendor::package.name'));

        return $table->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('modules.plugins.vendor::package.create'));

        return $formBuilder->create(PackageForm::class)->renderForm();
    }

    /**
     * Insert new Package into database
     *
     * @param PackageRequest $request
     * @return BaseHttpResponse
     */
    public function store(PackageRequest $request, BaseHttpResponse $response)
    {
        $package = $this->packageRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(PACKAGE_MODULE_SCREEN_NAME, $request, $package));

        return $response
            ->setPreviousUrl(route('package.index'))
            ->setNextUrl(route('package.edit', $package->id))
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
        $package = $this->packageRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $package));

        page_title()->setTitle(trans('modules.plugins.vendor::package.edit') . ' "' . $package->name . '"');

        return $formBuilder->create(PackageForm::class, ['model' => $package])->renderForm();
    }

    /**
     * @param $id
     * @param PackageRequest $request
     * @return BaseHttpResponse
     */
    public function update($id, PackageRequest $request, BaseHttpResponse $response)
    {
        $package = $this->packageRepository->findOrFail($id);

        $package->fill($request->input());

        $this->packageRepository->createOrUpdate($package);

        event(new UpdatedContentEvent(PACKAGE_MODULE_SCREEN_NAME, $request, $package));

        return $response
            ->setPreviousUrl(route('package.index'))
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
            $package = $this->packageRepository->findOrFail($id);

            $this->packageRepository->delete($package);

            event(new DeletedContentEvent(PACKAGE_MODULE_SCREEN_NAME, $request, $package));

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
            $package = $this->packageRepository->findOrFail($id);
            $this->packageRepository->delete($package);
            event(new DeletedContentEvent(PACKAGE_MODULE_SCREEN_NAME, $request, $package));
        }

        return $response->setMessage(trans('modules.base::notices.delete_success_message'));
    }
}
