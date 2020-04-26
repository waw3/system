<?php

namespace Modules\Plugins\Comments\Http\Controllers;

use Modules\Base\Events\BeforeEditContentEvent;
use Modules\Plugins\Comments\Http\Requests\CommentsRequest;
use Modules\Plugins\Comments\Repositories\Interfaces\CommentsInterface;
use Modules\Base\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use Exception;
use Modules\Plugins\Comments\Tables\CommentsTable;
use Modules\Base\Events\CreatedContentEvent;
use Modules\Base\Events\DeletedContentEvent;
use Modules\Base\Events\UpdatedContentEvent;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Plugins\Comments\Forms\CommentsForm;
use Modules\Base\Forms\FormBuilder;

class CommentsController extends BaseController
{
    /**
     * @var CommentsInterface
     */
    protected $commentsRepository;

    /**
     * CommentsController constructor.
     * @param CommentsInterface $commentsRepository
     */
    public function __construct(CommentsInterface $commentsRepository)
    {
        $this->commentsRepository = $commentsRepository;
    }

    /**
     * @param CommentsTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(CommentsTable $table)
    {
        page_title()->setTitle(trans('modules.plugins.comments::comments.name'));

        return $table->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('modules.plugins.comments::comments.create'));

        return $formBuilder->create(CommentsForm::class)->renderForm();
    }

    /**
     * Create new item
     *
     * @param CommentsRequest $request
     * @return BaseHttpResponse
     */
    public function store(CommentsRequest $request, BaseHttpResponse $response)
    {
        $comments = $this->commentsRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(COMMENTS_MODULE_SCREEN_NAME, $request, $comments));

        return $response
            ->setPreviousUrl(route('comments.index'))
            ->setNextUrl(route('comments.edit', $comments->id))
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
        $comments = $this->commentsRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $comments));

        page_title()->setTitle(trans('modules.plugins.comments::comments.edit') . ' "' . $comments->name . '"');

        return $formBuilder->create(CommentsForm::class, ['model' => $comments])->renderForm();
    }

    /**
     * @param $id
     * @param CommentsRequest $request
     * @return BaseHttpResponse
     */
    public function update($id, CommentsRequest $request, BaseHttpResponse $response)
    {
        $comments = $this->commentsRepository->findOrFail($id);

        $comments->fill($request->input());

        $this->commentsRepository->createOrUpdate($comments);

        event(new UpdatedContentEvent(COMMENTS_MODULE_SCREEN_NAME, $request, $comments));

        return $response
            ->setPreviousUrl(route('comments.index'))
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
            $comments = $this->commentsRepository->findOrFail($id);

            $this->commentsRepository->delete($comments);

            event(new DeletedContentEvent(COMMENTS_MODULE_SCREEN_NAME, $request, $comments));

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
            $comments = $this->commentsRepository->findOrFail($id);
            $this->commentsRepository->delete($comments);
            event(new DeletedContentEvent(COMMENTS_MODULE_SCREEN_NAME, $request, $comments));
        }

        return $response->setMessage(trans('modules.base::notices.delete_success_message'));
    }
}
