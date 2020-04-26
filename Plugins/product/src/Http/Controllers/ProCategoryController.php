<?php

namespace Modules\Plugins\Product\Http\Controllers;

use Modules\Base\Events\BeforeEditContentEvent;
use Modules\Base\Forms\FormBuilder;
use Modules\Base\Http\Controllers\BaseController;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Plugins\Product\Forms\ProCategoryForm;
use Modules\Plugins\Product\Tables\ProCategoryTable;
use Modules\Plugins\Product\Http\Requests\ProCategoryRequest;
use Modules\Plugins\Product\Repositories\Interfaces\ProCategoryInterface;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Base\Events\CreatedContentEvent;
use Modules\Base\Events\DeletedContentEvent;
use Modules\Base\Events\UpdatedContentEvent;
use Illuminate\View\View;
use Throwable;

class ProCategoryController extends BaseController
{

    /**
     * @var CategoryInterface
     */
    protected $procategoryRepository;

    /**
     * @param CategoryInterface $categoryRepository
     */
    public function __construct(ProCategoryInterface $procategoryRepository)
    {
        $this->procategoryRepository = $procategoryRepository;
    }

    /**
     * Display all categories
     * @param CategoryTable $dataTable
     * @return Factory|View
     *
     * @throws Throwable
     */
    public function index(ProCategoryTable $dataTable)
    {
        page_title()->setTitle(trans('modules.plugins.product::procategories.menu'));

        return $dataTable->renderTable();
    }

    /**
     * Show create form
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('modules.plugins.product::procategories.create'));

        return $formBuilder->create(ProCategoryForm::class)->renderForm();
    }

    /**
     * Insert new Category into database
     *
     * @param CategoryRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function store(ProCategoryRequest $request, BaseHttpResponse $response)
    {
        if ($request->input('is_default')) {
            $this->procategoryRepository->getModel()->where('id', '>', 0)->update(['is_default' => 0]);
        }

        $procategory = $this->procategoryRepository->createOrUpdate(array_merge($request->input(), [
            'author_id' => Auth::user()->getKey(),
        ]));

        event(new CreatedContentEvent(PROCATEGORY_MODULE_SCREEN_NAME, $request, $procategory));

        return $response
            ->setPreviousUrl(route('procategories.index'))
            ->setNextUrl(route('procategories.edit', $procategory->id))
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
        $procategory = $this->procategoryRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $procategory));

        page_title()->setTitle(trans('modules.plugins.product::procategories.edit') . ' "' . $procategory->name . '"');

        return $formBuilder->create(ProCategoryForm::class, ['model' => $procategory])->renderForm();
    }

    /**
     * @param int $id
     * @param CategoryRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function update($id, ProCategoryRequest $request, BaseHttpResponse $response)
    {
        $procategory = $this->procategoryRepository->findOrFail($id);

        if ($request->input('is_default')) {
            $this->procategoryRepository->getModel()->where('id', '!=', $id)->update(['is_default' => 0]);
        }

        $procategory->fill($request->input());

        $this->procategoryRepository->createOrUpdate($procategory);

        event(new UpdatedContentEvent(PROCATEGORY_MODULE_SCREEN_NAME, $request, $procategory));

        return $response
            ->setPreviousUrl(route('procategories.index'))
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
            $procategory = $this->procategoryRepository->findOrFail($id);

            if (!$procategory->is_default) {
                $this->procategoryRepository->delete($procategory);
                event(new DeletedContentEvent(PROCATEGORY_MODULE_SCREEN_NAME, $request, $procategory));
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
            $procategory = $this->procategoryRepository->findOrFail($id);
            if (!$procategory->is_default) {
                $this->procategoryRepository->delete($procategory);

                event(new DeletedContentEvent(PROCATEGORY_MODULE_SCREEN_NAME, $request, $procategory));
            }
        }

        return $response->setMessage(trans('modules.base::notices.delete_success_message'));
    }
}
