<?php

namespace Modules\Page\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Modules\Base\Events\BeforeEditContentEvent;
use Modules\Base\Events\CreatedContentEvent;
use Modules\Base\Events\DeletedContentEvent;
use Modules\Base\Events\UpdatedContentEvent;
use Modules\Base\Http\Controllers\BaseController;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Base\Traits\HasDeleteManyItemsTrait;
use Modules\Page\Forms\PageForm;
use Modules\Page\Tables\PageTable;
use Modules\Page\Http\Requests\PageRequest;
use Modules\Page\Repositories\Interfaces\PageInterface;
use Exception;
use Illuminate\Http\Request;
use Modules\Base\Forms\FormBuilder;
use Illuminate\View\View;
use Throwable;

class PageController extends BaseController
{

    use HasDeleteManyItemsTrait;

    /**
     * @var PageInterface
     */
    protected $pageRepository;

    /**
     * PageController constructor.
     * @param PageInterface $pageRepository
     */
    public function __construct(PageInterface $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    /**
     * @param PageTable $dataTable
     * @return JsonResponse|View
     *
     * @throws Throwable
     */
    public function index(PageTable $dataTable)
    {
        page_title()->setTitle(trans('modules.page::pages.menu_name'));

        return $dataTable->renderTable();
    }

    /**
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('modules.page::pages.create'));

        return $formBuilder->create(PageForm::class)->renderForm();
    }

    /**
     * @param PageRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function store(PageRequest $request, BaseHttpResponse $response)
    {
        $page = $this->pageRepository->createOrUpdate(array_merge($request->input(), [
            'user_id' => Auth::user()->getKey(),
        ]));

        event(new CreatedContentEvent(PAGE_MODULE_SCREEN_NAME, $request, $page));

        return $response->setPreviousUrl(route('pages.index'))
            ->setNextUrl(route('pages.edit', $page->id))
            ->setMessage(trans('modules.base::notices.create_success_message'));
    }

    /**
     * @param Request $request
     * @param $id
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function edit(Request $request, $id, FormBuilder $formBuilder)
    {
        $page = $this->pageRepository->findOrFail($id);

        page_title()->setTitle(trans('modules.page::pages.edit') . ' "' . $page->name . '"');

        event(new BeforeEditContentEvent($request, $page));

        return $formBuilder->create(PageForm::class, ['model' => $page])->renderForm();
    }

    /**
     * @param $id
     * @param PageRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function update($id, PageRequest $request, BaseHttpResponse $response)
    {
        $page = $this->pageRepository->findOrFail($id);
        $page->fill($request->input());

        $page = $this->pageRepository->createOrUpdate($page);

        event(new UpdatedContentEvent(PAGE_MODULE_SCREEN_NAME, $request, $page));

        return $response
            ->setPreviousUrl(route('pages.index'))
            ->setMessage(trans('modules.base::notices.update_success_message'));
    }

    /**
     * @param Request $request
     * @param $id
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function destroy(Request $request, $id, BaseHttpResponse $response)
    {
        try {
            $page = $this->pageRepository->findOrFail($id);
            $this->pageRepository->delete($page);

            event(new DeletedContentEvent(PAGE_MODULE_SCREEN_NAME, $request, $page));

            return $response->setMessage(trans('modules.page::pages.deleted'));
        } catch (Exception $ex) {
            return $response
                ->setError()
                ->setMessage($ex->getMessage());
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
        return $this->executeDeleteItems($request, $response, $this->pageRepository, PAGE_MODULE_SCREEN_NAME);
    }
}
