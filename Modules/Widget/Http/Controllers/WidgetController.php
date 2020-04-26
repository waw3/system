<?php

namespace Modules\Widget\Http\Controllers;

use Assets;
use Modules\Base\Http\Controllers\BaseController;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Setting\Supports\SettingStore;
use Modules\Widget\Factories\AbstractWidgetFactory;
use Modules\Widget\Repositories\Interfaces\WidgetInterface;
use Modules\Widget\Services\WidgetId;
use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Language;
use Throwable;
use WidgetGroup;

class WidgetController extends BaseController
{
    /**
     * @var WidgetInterface
     */
    protected $widgetRepository;

    /**
     * @var null
     */
    protected $theme = null;

    /**
     * WidgetController constructor.
     * @param WidgetInterface $widgetRepository
     * @param SettingStore $setting
     * @throws FileNotFoundException
     */
    public function __construct(WidgetInterface $widgetRepository, SettingStore $setting)
    {
        $this->widgetRepository = $widgetRepository;
        $this->theme = $setting->get('theme') . $this->getCurrentLocaleCode();
    }

    /**
     * @return Factory|View
     *
     * @throws FileNotFoundException
     * @since 24/09/2016 2:10 PM
     */
    public function index()
    {
        page_title()->setTitle(trans('modules.base::layouts.widgets'));

        Assets::addScripts(['sortable'])
            ->addScriptsDirectly('vendor/core/packages/widget/js/widget.js');

        $widgets = $this->widgetRepository->getByTheme($this->theme);
        foreach ($widgets as $widget) {
            WidgetGroup::group($widget->sidebar_id)
                ->position($widget->position)
                ->addWidget($widget->widget_id, $widget->data);
        }

        return view('modules.widget::list');
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws Throwable
     * @since 24/09/2016 3:14 PM
     */
    public function postSaveWidgetToSidebar(Request $request, BaseHttpResponse $response)
    {
        try {
            $sidebar_id = $request->get('sidebar_id');
            $this->widgetRepository->deleteBy([
                'sidebar_id' => $sidebar_id,
                'theme'      => $this->theme,
            ]);
            foreach ($request->get('items', []) as $key => $item) {
                parse_str($item, $data);
                $args = [
                    'sidebar_id' => $sidebar_id,
                    'widget_id'  => $data['id'],
                    'theme'      => $this->theme,
                    'position'   => $key,
                    'data'       => $data,
                ];
                $this->widgetRepository->createOrUpdate($args);
            }

            $widget_areas = $this->widgetRepository->allBy([
                'sidebar_id' => $sidebar_id,
                'theme'      => $this->theme,
            ]);
            return $response
                ->setData(view('modules.widget::item', compact('widget_areas'))->render())
                ->setMessage(trans('modules.widget::global.save_success'));
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
     */
    public function postDelete(Request $request, BaseHttpResponse $response)
    {
        try {
            $this->widgetRepository->deleteBy([
                'theme'      => $this->theme,
                'sidebar_id' => $request->get('sidebar_id'),
                'position'   => $request->get('position'),
                'widget_id'  => $request->get('widget_id'),
            ]);
            return $response->setMessage(trans('modules.widget::global.delete_success'));
        } catch (Exception $ex) {
            return $response
                ->setError()
                ->setMessage($ex->getMessage());
        }
    }

    /**
     * The action to show widget output via ajax.
     *
     * @param Request $request
     *
     * @param Application $application
     * @return mixed
     * @throws BindingResolutionException
     */
    public function showWidget(Request $request, Application $application)
    {
        $this->prepareGlobals($request);

        $factory = $application->make('modules.widget');
        $widgetName = $request->input('name', '');
        $widgetParams = $factory->decryptWidgetParams($request->input('params', ''));

        return call_user_func_array([$factory, $widgetName], $widgetParams);
    }

    /**
     * Set some specials variables to modify the workflow of the widget factory.
     *
     * @param Request $request
     */
    protected function prepareGlobals(Request $request)
    {
        WidgetId::set($request->input('id', 1) - 1);
        AbstractWidgetFactory::$skipWidgetContainer = true;
    }

    /**
     * @return null|string
     * @throws FileNotFoundException
     */
    protected function getCurrentLocaleCode()
    {
        $language_code = null;
        if (is_plugin_active('language')) {
            $current_locale = is_in_admin() ? Language::getCurrentAdminLocaleCode() : Language::getCurrentLocaleCode();
            $language_code = $current_locale && $current_locale != Language::getDefaultLocaleCode() ? '-' . $current_locale : null;
        }

        return $language_code;
    }
}
