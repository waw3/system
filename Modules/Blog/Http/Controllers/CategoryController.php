<?php

namespace Modules\Blog\Http\Controllers;

use Exception, Throwable, Auth, BaseController;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Modules\Base\Events\BeforeEditContentEvent;
use Modules\Base\Forms\FormBuilder;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Base\Events\CreatedContentEvent;
use Modules\Base\Events\DeletedContentEvent;
use Modules\Base\Events\UpdatedContentEvent;
use Modules\Blog\Forms\CategoryForm;
use Modules\Blog\Tables\CategoryTable;
use Modules\Blog\Http\Requests\CategoryRequest;
use Modules\Blog\Repositories\Interfaces\CategoryInterface;


class CategoryController extends BaseController
{

    /**
     * @var CategoryInterface
     */
    protected $categoryRepository;

    /**
     * @param CategoryInterface $categoryRepository
     */
    public function __construct(CategoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display all categories
     * @param CategoryTable $dataTable
     * @return Factory|View
     *
     * @throws Throwable
     */
    public function index(CategoryTable $dataTable)
    {
        page_title()->setTitle(trans('modules.blog::categories.menu'));

        return $dataTable->renderTable();
    }

    /**
     * Show create form
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('modules.blog::categories.create'));

        return $formBuilder->create(CategoryForm::class)->renderForm();
    }

    /**
     * Insert new Category into database
     *
     * @param CategoryRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function store(CategoryRequest $request, BaseHttpResponse $response)
    {
        if ($request->input('is_default')) {
            $this->categoryRepository->getModel()->where('id', '>', 0)->update(['is_default' => 0]);
        }

        $category = $this->categoryRepository->createOrUpdate(array_merge($request->input(), [
            'author_id' => Auth::user()->getKey(),
        ]));

        event(new CreatedContentEvent(CATEGORY_MODULE_SCREEN_NAME, $request, $category));

        return $response
            ->setPreviousUrl(route('categories.index'))
            ->setNextUrl(route('categories.edit', $category->id))
            ->setMessage(trans('modules.base::notices.create_success_message'));
    }

    /**
     * Show edit form
     *
     * @param Request $request
     * @param int $id
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function edit(Request $request, $id, FormBuilder $formBuilder)
    {
        $category = $this->categoryRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $category));

        page_title()->setTitle(trans('modules.blog::categories.edit') . ' "' . $category->name . '"');

        return $formBuilder->create(CategoryForm::class, ['model' => $category])->renderForm();
    }

    /**
     * @param int $id
     * @param CategoryRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function update($id, CategoryRequest $request, BaseHttpResponse $response)
    {
        $category = $this->categoryRepository->findOrFail($id);

        if ($request->input('is_default')) {
            $this->categoryRepository->getModel()->where('id', '!=', $id)->update(['is_default' => 0]);
        }

        $category->fill($request->input());

        $this->categoryRepository->createOrUpdate($category);

        event(new UpdatedContentEvent(CATEGORY_MODULE_SCREEN_NAME, $request, $category));

        return $response
            ->setPreviousUrl(route('categories.index'))
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
            $category = $this->categoryRepository->findOrFail($id);

            if (!$category->is_default) {
                $this->categoryRepository->delete($category);
                event(new DeletedContentEvent(CATEGORY_MODULE_SCREEN_NAME, $request, $category));
            }

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
        $ids = $request->input('ids');
        if (empty($ids)) {
            return $response->setMessage(trans('modules.base::notices.no_select'));
        }

        foreach ($ids as $id) {
            $category = $this->categoryRepository->findOrFail($id);
            if (!$category->is_default) {
                $this->categoryRepository->delete($category);

                event(new DeletedContentEvent(CATEGORY_MODULE_SCREEN_NAME, $request, $category));
            }
        }

        return $response->setMessage(trans('modules.base::notices.delete_success_message'));
    }
}
