<?php

namespace Modules\Menu\Http\Controllers;

use Assets;
use Modules\Base\Events\BeforeEditContentEvent;
use Modules\Base\Events\CreatedContentEvent;
use Modules\Base\Events\DeletedContentEvent;
use Modules\Base\Events\UpdatedContentEvent;
use Modules\Base\Forms\FormBuilder;
use Modules\Base\Http\Controllers\BaseController;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Menu\Forms\MenuForm;
use Modules\Menu\Repositories\Interfaces\MenuLocationInterface;
use Modules\Menu\Tables\MenuTable;
use Modules\Menu\Http\Requests\MenuRequest;
use Modules\Menu\Repositories\Eloquent\MenuRepository;
use Modules\Menu\Repositories\Interfaces\MenuInterface;
use Modules\Menu\Repositories\Interfaces\MenuNodeInterface;
use Modules\Support\Services\Cache\Cache;
use Exception;
use Illuminate\Cache\CacheManager;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Menu;
use stdClass;
use Throwable;

class MenuController extends BaseController
{

    /**
     * @var MenuInterface
     */
    protected $menuRepository;

    /**
     * @var MenuNodeInterface
     */
    protected $menuNodeRepository;

    /**
     * @var MenuLocationInterface
     */
    protected $menuLocationRepository;

    /**
     * @var Cache
     */
    protected $cache;

    /**
     * MenuController constructor.
     * @param MenuInterface $menuRepository
     * @param MenuNodeInterface $menuNodeRepository
     * @param MenuLocationInterface $menuLocationRepository
     * @param CacheManager $cache
     */
    public function __construct(
        MenuInterface $menuRepository,
        MenuNodeInterface $menuNodeRepository,
        MenuLocationInterface $menuLocationRepository,
        CacheManager $cache
    ) {
        $this->menuRepository = $menuRepository;
        $this->menuNodeRepository = $menuNodeRepository;
        $this->menuLocationRepository = $menuLocationRepository;
        $this->cache = new Cache($cache, MenuRepository::class);
    }

    /**
     * @param MenuTable $dataTable
     * @return Factory|View
     * @throws Throwable
     */
    public function index(MenuTable $dataTable)
    {
        page_title()->setTitle(trans('modules.base::layouts.menu'));

        return $dataTable->renderTable();
    }

    /**
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('modules.menu::menu.create'));

        return $formBuilder->create(MenuForm::class)->renderForm();
    }

    /**
     * @param MenuRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws Exception
     */
    public function store(MenuRequest $request, BaseHttpResponse $response)
    {
        $menu = $this->menuRepository->getModel();

        $menu->fill($request->input());
        $menu->slug = $this->menuRepository->createSlug($request->input('name'));
        $menu = $this->menuRepository->createOrUpdate($menu);

        $this->cache->flush();

        event(new CreatedContentEvent(MENU_MODULE_SCREEN_NAME, $request, $menu));

        $this->saveMenuLocations($menu, $request);

        return $response
            ->setPreviousUrl(route('menus.index'))
            ->setNextUrl(route('menus.edit', $menu->id))
            ->setMessage(trans('modules.base::notices.create_success_message'));
    }

    /**
     * @param $menu
     * @param Request $request
     * @return bool
     * @throws Exception
     */
    protected function saveMenuLocations($menu, Request $request)
    {
        $locations = $request->input('locations', []);

        $this->menuLocationRepository
            ->getModel()
            ->where('menu_id', $menu->id)
            ->whereNotIn('location', $locations)
            ->delete();

        foreach ($locations as $location) {
            $menuLocation = $this->menuLocationRepository->firstOrCreate([
                'menu_id'  => $menu->id,
                'location' => $location,
            ]);

            event(new CreatedContentEvent(MENU_LOCATION_MODULE_SCREEN_NAME, $request, $menuLocation));
        }

        return true;
    }

    /**
     * @param $id
     * @param Request $request
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function edit($id, Request $request, FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('modules.menu::menu.edit'));

        Assets::addScripts(['jquery-nestable'])
            ->addStyles(['jquery-nestable'])
            ->addScriptsDirectly('vendor/core/packages/menu/js/menu.js');

        $oldInputs = old();
        if ($oldInputs && $id == 0) {
            $oldObject = new stdClass;
            foreach ($oldInputs as $key => $row) {
                $oldObject->$key = $row;
            }
            $menu = $oldObject;
        } else {
            $menu = $this->menuRepository->findOrFail($id);
        }

        event(new BeforeEditContentEvent($request, $menu));

        return $formBuilder->create(MenuForm::class, ['model' => $menu])->renderForm();
    }

    /**
     * @param MenuRequest $request
     * @param $id
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws Exception
     */
    public function update(MenuRequest $request, $id, BaseHttpResponse $response)
    {
        $menu = $this->menuRepository->firstOrNew(compact('id'));

        $menu->fill($request->input());
        $this->menuRepository->createOrUpdate($menu);
        event(new UpdatedContentEvent(MENU_MODULE_SCREEN_NAME, $request, $menu));

        $this->saveMenuLocations($menu, $request);

        $deletedNodes = explode(' ', ltrim($request->input('deleted_nodes', '')));
        if ($deletedNodes) {
            $this->menuNodeRepository->getModel()->whereIn('id', $deletedNodes)->delete();
        }
        Menu::recursiveSaveMenu(json_decode($request->input('menu_nodes'), true), $menu->id, 0);

        $this->cache->flush();

        return $response
            ->setPreviousUrl(route('menus.index'))
            ->setMessage(trans('modules.base::notices.create_success_message'));
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
            $menu = $this->menuRepository->findOrFail($id);
            $this->menuNodeRepository->deleteBy(['menu_id' => $menu->id]);
            $this->menuRepository->delete($menu);

            event(new DeletedContentEvent(MENU_MODULE_SCREEN_NAME, $request, $menu));

            return $response->setMessage(trans('modules.base::notices.delete_success_message'));
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
        $ids = $request->input('ids');
        if (empty($ids)) {
            return $response
                ->setError()
                ->setMessage(trans('modules.base::notices.no_select'));
        }

        foreach ($ids as $id) {
            $menu = $this->menuRepository->findOrFail($id);
            $this->menuNodeRepository->deleteBy(['menu_id' => $menu->id]);
            $this->menuRepository->delete($menu);
            event(new DeletedContentEvent(MENU_MODULE_SCREEN_NAME, $request, $menu));
        }

        return $response->setMessage(trans('modules.base::notices.delete_success_message'));
    }
}
