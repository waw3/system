<?php

namespace Modules\Plugins\Location\Http\Controllers;

use Modules\Base\Enums\BaseStatusEnum;
use Modules\Base\Events\BeforeEditContentEvent;
use Modules\Plugins\Location\Http\Requests\CityRequest;
use Modules\Plugins\Location\Http\Resources\CityResource;
use Modules\Plugins\Location\Repositories\Interfaces\CityInterface;
use Modules\Base\Http\Controllers\BaseController;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Exception;
use Modules\Plugins\Location\Tables\CityTable;
use Modules\Base\Events\CreatedContentEvent;
use Modules\Base\Events\DeletedContentEvent;
use Modules\Base\Events\UpdatedContentEvent;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Plugins\Location\Forms\CityForm;
use Modules\Base\Forms\FormBuilder;
use Illuminate\View\View;
use Throwable;

class CityController extends BaseController
{
    /**
     * @var CityInterface
     */
    protected $cityRepository;

    /**
     * CityController constructor.
     * @param CityInterface $cityRepository
     */
    public function __construct(CityInterface $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    /**
     * Display all cities
     * @param CityTable $dataTable
     * @return Factory|View
     * @throws Throwable
     */
    public function index(CityTable $table)
    {

        page_title()->setTitle(trans('modules.plugins.location::city.name'));

        return $table->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('modules.plugins.location::city.create'));

        return $formBuilder->create(CityForm::class)->renderForm();
    }

    /**
     * Insert new City into database
     *
     * @param CityRequest $request
     * @return BaseHttpResponse
     */
    public function store(CityRequest $request, BaseHttpResponse $response)
    {
        $city = $this->cityRepository->createOrUpdate($request->input());

        event(new CreatedContentEvent(CITY_MODULE_SCREEN_NAME, $request, $city));

        return $response
            ->setPreviousUrl(route('city.index'))
            ->setNextUrl(route('city.edit', $city->id))
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
        $city = $this->cityRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $city));

        page_title()->setTitle(trans('modules.plugins.location::city.edit') . ' "' . $city->name . '"');

        return $formBuilder->create(CityForm::class, ['model' => $city])->renderForm();
    }

    /**
     * @param $id
     * @param CityRequest $request
     * @return BaseHttpResponse
     */
    public function update($id, CityRequest $request, BaseHttpResponse $response)
    {
        $city = $this->cityRepository->findOrFail($id);

        $city->fill($request->input());

        $this->cityRepository->createOrUpdate($city);

        event(new UpdatedContentEvent(CITY_MODULE_SCREEN_NAME, $request, $city));

        return $response
            ->setPreviousUrl(route('city.index'))
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
            $city = $this->cityRepository->findOrFail($id);

            $this->cityRepository->delete($city);

            event(new DeletedContentEvent(CITY_MODULE_SCREEN_NAME, $request, $city));

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
            $city = $this->cityRepository->findOrFail($id);
            $this->cityRepository->delete($city);
            event(new DeletedContentEvent(CITY_MODULE_SCREEN_NAME, $request, $city));
        }

        return $response->setMessage(trans('modules.base::notices.delete_success_message'));
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     */
    public function getList(Request $request, BaseHttpResponse $response)
    {
        $keyword = $request->input('q');

        if (!$keyword) {
            return $response->setData([]);
        }

        $data = $this->cityRepository->advancedGet([
            'condition' => [
                ['cities.name', 'LIKE', '%' . $keyword . '%'],
            ],
            'select' => ['cities.id', 'cities.name'],
            'take' => 10,

        ]);

        return $response->setData(CityResource::collection($data));
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function getCitiesByStateId(Request $request, BaseHttpResponse $response)
    {
        if (!$request->input('state_id')) {
            return $response;
        }

        $cities = $this->cityRepository->advancedGet([
            'condition' => [
                'status' => BaseStatusEnum::PUBLISHED,
                'state_id' => $request->input('state_id'),
            ],
            'order_by' => ['order' => 'DESC'],
            'select' => ['id', 'name'],
        ]);

        return $response->setData($cities);
    }
}
