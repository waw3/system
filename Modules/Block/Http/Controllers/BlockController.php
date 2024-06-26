<?php

namespace Modules\Block\Http\Controllers;

use Modules\Base\Events\BeforeEditContentEvent;
use Modules\Base\Forms\FormBuilder;
use Modules\Base\Http\Controllers\BaseController;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Base\Traits\HasDeleteManyItemsTrait;
use Modules\Block\Forms\BlockForm;
use Modules\Block\Http\Requests\BlockRequest;
use Modules\Block\Repositories\Interfaces\BlockInterface;
use Illuminate\Http\Request;
use Exception;
use Modules\Block\Tables\BlockTable;
use Illuminate\Support\Facades\Auth;
use Modules\Base\Events\CreatedContentEvent;
use Modules\Base\Events\DeletedContentEvent;
use Modules\Base\Events\UpdatedContentEvent;

class BlockController extends BaseController
{
    use HasDeleteManyItemsTrait;

    /**
     * @var BlockInterface
     */
    protected $blockRepository;

    /**
     * BlockController constructor.
     * @param BlockInterface $blockRepository
     */
    public function __construct(BlockInterface $blockRepository)
    {
        $this->blockRepository = $blockRepository;
    }

    /**
     * Display all block
     * @param BlockTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @throws \Throwable
     */
    public function index(BlockTable $dataTable)
    {
        page_title()->setTitle(trans('modules.block::block.menu'));

        return $dataTable->renderTable();
    }

    /**
     * Show create form
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('modules.block::block.create'));

        return $formBuilder->create(BlockForm::class)->renderForm();
    }

    /**
     * Insert new Block into database
     *
     * @param BlockRequest $request
     * @return BaseHttpResponse
     */
    public function store(BlockRequest $request, BaseHttpResponse $response)
    {
        $block = $this->blockRepository->getModel();
        $block->fill($request->input());
        $block->user_id = Auth::user()->getKey();
        $block->alias = $this->blockRepository->createSlug($request->input('alias'), null);

        $this->blockRepository->createOrUpdate($block);

        event(new CreatedContentEvent('block', $request, $block));

        return $response
            ->setPreviousUrl(route('block.index'))
            ->setNextUrl(route('block.edit', $block->id))
            ->setMessage(trans('modules.base::notices.create_success_message'));
    }

    /**
     * Show edit form
     *
     * @param int $id
     * @param FormBuilder $formBuilder
     * @param Request $request
     * @return string
     */
    public function edit($id, FormBuilder $formBuilder, Request $request)
    {
        $block = $this->blockRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $block));

        page_title()->setTitle(trans('modules.block::block.edit') . ' "' . $block->name . '"');

        return $formBuilder->create(BlockForm::class, ['model' => $block])->renderForm();
    }

    /**
     * @param int $id
     * @param BlockRequest $request
     * @return BaseHttpResponse
     */
    public function update($id, BlockRequest $request, BaseHttpResponse $response)
    {
        $block = $this->blockRepository->findOrFail($id);
        $block->fill($request->input());
        $block->alias = $this->blockRepository->createSlug($request->input('alias'), $id);

        $this->blockRepository->createOrUpdate($block);

        event(new UpdatedContentEvent('block', $request, $block));

        return $response
            ->setPreviousUrl(route('block.index'))
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
            $block = $this->blockRepository->findOrFail($id);
            $this->blockRepository->delete($block);
            event(new DeletedContentEvent('block', $request, $block));

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
     *
     * @throws Exception
     */
    public function deletes(Request $request, BaseHttpResponse $response)
    {
        return $this->executeDeleteItems($request, $response, $this->blockRepository, 'block');
    }
}
