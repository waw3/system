<?php

namespace Modules\Plugins\Product\Http\Controllers;

use Modules\Base\Events\BeforeEditContentEvent;
use Modules\Base\Forms\FormBuilder;
use Modules\Base\Http\Controllers\BaseController;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Base\Traits\HasDeleteManyItemsTrait;
use Modules\Plugins\Product\Forms\ProTagForm;
use Modules\Plugins\Product\Tables\ProTagTable;
use Modules\Plugins\Product\Http\Requests\ProTagRequest;
use Modules\Plugins\Product\Repositories\Interfaces\ProTagInterface;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Base\Events\CreatedContentEvent;
use Modules\Base\Events\DeletedContentEvent;
use Modules\Base\Events\UpdatedContentEvent;
use Illuminate\View\View;
use Throwable;

class ProTagController extends BaseController
{

    use HasDeleteManyItemsTrait;

    /**
     * @var TagInterface
     */
    protected $protagRepository;

    /**
     * @param TagInterface $tagRepository
     */
    public function __construct(ProTagInterface $protagRepository)
    {
        $this->protagRepository = $protagRepository;
    }

    /**
     * @param TagTable $dataTable
     * @return Factory|View
     *
     * @throws Throwable
     */
    public function index(ProTagTable $dataTable)
    {
        page_title()->setTitle(trans('modules.plugins.product::protags.menu'));

        return $dataTable->renderTable();
    }

    /**
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('modules.plugins.product::protags.create'));

        return $formBuilder->create(ProTagForm::class)->renderForm();
    }

    /**
     * @param TagRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function store(ProTagRequest $request, BaseHttpResponse $response)
    {
        $protag = $this->protagRepository->createOrUpdate(array_merge($request->input(),
            ['author_id' => Auth::user()->getKey()]));
        event(new CreatedContentEvent(PROTAG_MODULE_SCREEN_NAME, $request, $protag));

        return $response
            ->setPreviousUrl(route('protags.index'))
            ->setNextUrl(route('protags.edit', $protag->id))
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
        $protag = $this->protagRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $protag));

        page_title()->setTitle(trans('modules.plugins.product::protags.edit') . ' "' . $protag->name . '"');

        return $formBuilder->create(ProTagForm::class, ['model' => $protag])->renderForm();
    }

    /**
     * @param int $id
     * @param TagRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function update($id, ProTagRequest $request, BaseHttpResponse $response)
    {
        $protag = $this->protagRepository->findOrFail($id);
        $protag->fill($request->input());

        $this->protagRepository->createOrUpdate($protag);
        event(new UpdatedContentEvent(PROTAG_MODULE_SCREEN_NAME, $request, $protag));

        return $response
            ->setPreviousUrl(route('protags.index'))
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
            $protag = $this->protagRepository->findOrFail($id);
            $this->protagRepository->delete($protag);

            event(new DeletedContentEvent(PROTAG_MODULE_SCREEN_NAME, $request, $protag));

            return $response->setMessage(trans('modules.plugins.product::protags.deleted'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage(trans('modules.plugins.product::protags.cannot_delete'));
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
        return $this->executeDeleteItems($request, $response, $this->protagRepository, PROTAG_MODULE_SCREEN_NAME);
    }

    /**
     * Get list tags in db
     *
     * @return array
     */
    public function getAllProTags()
    {
        return $this->protagRepository->pluck('name');
    }
}
