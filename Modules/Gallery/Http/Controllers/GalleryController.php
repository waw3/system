<?php

namespace Modules\Gallery\Http\Controllers;

use Modules\Base\Events\BeforeEditContentEvent;
use Modules\Base\Forms\FormBuilder;
use Modules\Base\Http\Controllers\BaseController;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Base\Traits\HasDeleteManyItemsTrait;
use Modules\Gallery\Forms\GalleryForm;
use Modules\Gallery\Tables\GalleryTable;
use Modules\Gallery\Http\Requests\GalleryRequest;
use Modules\Gallery\Repositories\Interfaces\GalleryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Base\Events\CreatedContentEvent;
use Modules\Base\Events\DeletedContentEvent;
use Modules\Base\Events\UpdatedContentEvent;

class GalleryController extends BaseController
{
    use HasDeleteManyItemsTrait;

    /**
     * @var GalleryInterface
     */
    protected $galleryRepository;

    /**
     * @param GalleryInterface $galleryRepository
     */
    public function __construct(GalleryInterface $galleryRepository)
    {
        $this->galleryRepository = $galleryRepository;
    }

    /**
     * Display all galleries
     * @param GalleryTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(GalleryTable $dataTable)
    {
        page_title()->setTitle(trans('modules.gallery::gallery.galleries'));

        return $dataTable->renderTable();
    }

    /**
     * Show create form
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('modules.gallery::gallery.create'));

        return $formBuilder->create(GalleryForm::class)->renderForm();
    }

    /**
     * Insert new Gallery into database
     *
     * @param GalleryRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function store(GalleryRequest $request, BaseHttpResponse $response)
    {
        $gallery = $this->galleryRepository->getModel();
        $gallery->fill($request->input());
        $gallery->user_id = Auth::user()->getKey();

        $gallery = $this->galleryRepository->createOrUpdate($gallery);

        event(new CreatedContentEvent(GALLERY_MODULE_SCREEN_NAME, $request, $gallery));

        return $response
            ->setPreviousUrl(route('galleries.index'))
            ->setNextUrl(route('galleries.edit', $gallery->id))
            ->setMessage(trans('modules.base::notices.create_success_message'));
    }

    /**
     * Show edit form
     *
     * @param int $id
     * @param Request $request
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function edit($id, Request $request, FormBuilder $formBuilder)
    {
        $gallery = $this->galleryRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $gallery));

        page_title()->setTitle(trans('modules.gallery::gallery.edit') . ' "' . $gallery->name . '"');

        return $formBuilder->create(GalleryForm::class, ['model' => $gallery])->renderForm();
    }

    /**
     * @param int $id
     * @param GalleryRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function update($id, GalleryRequest $request, BaseHttpResponse $response)
    {
        $gallery = $this->galleryRepository->findOrFail($id);
        $gallery->fill($request->input());

        $this->galleryRepository->createOrUpdate($gallery);

        event(new UpdatedContentEvent(GALLERY_MODULE_SCREEN_NAME, $request, $gallery));

        return $response
            ->setPreviousUrl(route('galleries.index'))
            ->setMessage(trans('modules.base::notices.update_success_message'));
    }

    /**
     * @param Request $request
     * @param int $id
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function destroy(Request $request, $id, BaseHttpResponse $response)
    {
        try {
            $gallery = $this->galleryRepository->findOrFail($id);
            $this->galleryRepository->delete($gallery);
            event(new DeletedContentEvent(GALLERY_MODULE_SCREEN_NAME, $request, $gallery));

            return $response->setMessage(trans('modules.base::notices.delete_success_message'));
        } catch (Exception $ex) {
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
        return $this->executeDeleteItems($request, $response, $this->galleryRepository, GALLERY_MODULE_SCREEN_NAME);
    }
}
