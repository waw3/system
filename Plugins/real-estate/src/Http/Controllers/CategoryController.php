<?php

namespace Modules\Plugins\RealEstate\Http\Controllers;

use Modules\Base\Events\BeforeEditContentEvent;
use Modules\Plugins\RealEstate\Http\Requests\CategoryRequest;
use Modules\Plugins\RealEstate\Repositories\Interfaces\CategoryInterface;
use Modules\Base\Http\Controllers\BaseController;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Exception;
use Modules\Plugins\RealEstate\Tables\CategoryTable;
use Modules\Base\Events\CreatedContentEvent;
use Modules\Base\Events\DeletedContentEvent;
use Modules\Base\Events\UpdatedContentEvent;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Plugins\RealEstate\Forms\CategoryForm;
use Modules\Base\Forms\FormBuilder;
use Illuminate\View\View;
use Throwable;

class CategoryController extends BaseController
{
    /**
     * @var CategoryInterface
     */
    protected $categoryRepository;

    /**
     * CategoryController constructor.
     * @param CategoryInterface $categoryRepository
     */
    public function __construct(CategoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param CategoryTable $dataTable
     * @return Factory|View
     * @throws Throwable
     */
    public function index(CategoryTable $table)
    {

        page_title()->setTitle(trans('modules.plugins.real-estate::category.name'));

        return $table->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('modules.plugins.real-estate::category.create'));

        return $formBuilder->create(CategoryForm::class)->renderForm();
    }

    /**
     * Insert new Category into database
     *
     * @param CategoryRequest $request
     * @return BaseHttpResponse
     */
    public function store(CategoryRequest $request, BaseHttpResponse $response)
    {
        $category = $this->categoryRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(CATEGORY_MODULE_SCREEN_NAME, $request, $category));

        return $response
            ->setPreviousUrl(route('category.index'))
            ->setNextUrl(route('category.edit', $category->id))
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
        $category = $this->categoryRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $category));

        page_title()->setTitle(trans('modules.plugins.real-estate::category.edit') . ' "' . $category->name . '"');

        return $formBuilder->create(CategoryForm::class, ['model' => $category])->renderForm();
    }

    /**
     * @param $id
     * @param CategoryRequest $request
     * @return BaseHttpResponse
     */
    public function update($id, CategoryRequest $request, BaseHttpResponse $response)
    {
        $category = $this->categoryRepository->findOrFail($id);

        $category->fill($request->input());

        $this->categoryRepository->createOrUpdate($category);

        event(new UpdatedContentEvent(CATEGORY_MODULE_SCREEN_NAME, $request, $category));

        return $response
            ->setPreviousUrl(route('category.index'))
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
            $category = $this->categoryRepository->findOrFail($id);

            $this->categoryRepository->delete($category);

            event(new DeletedContentEvent(CATEGORY_MODULE_SCREEN_NAME, $request, $category));

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
            $category = $this->categoryRepository->findOrFail($id);
            $this->categoryRepository->delete($category);
            event(new DeletedContentEvent(CATEGORY_MODULE_SCREEN_NAME, $request, $category));
        }

        return $response->setMessage(trans('modules.base::notices.delete_success_message'));
    }
}
