<?php

namespace Modules\Plugins\MaintenanceMode\Http\Controllers;

use Assets;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Plugins\MaintenanceMode\Supports\MaintenanceMode;
use Modules\Plugins\MaintenanceMode\Http\Requests\MaintenanceModeRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class MaintenanceModeController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex()
    {
        page_title()->setTitle(trans('modules.plugins.maintenance-mode::maintenance-mode.maintenance_mode'));

        Assets::addScriptsDirectly(['vendor/core/plugins/maintenance-mode/js/maintenance.js']);

        $isDownForMaintenance = app()->isDownForMaintenance();

        return view('modules.plugins.maintenance-mode::maintenance', compact('isDownForMaintenance'));
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @param MaintenanceMode $maintenanceMode
     * @return BaseHttpResponse
     */
    public function postRun(
        MaintenanceModeRequest $request,
        BaseHttpResponse $response,
        MaintenanceMode $maintenanceMode
    )
    {
        if (app()->isDownForMaintenance()) {
            $maintenanceMode->up();
            return $response
                ->setMessage(trans('modules.plugins.maintenance-mode::maintenance-mode.application_live'))
                ->setData([
                    'is_down' => false,
                    'notice'  => trans('modules.plugins.maintenance-mode::maintenance-mode.notice_disable'),
                    'message' => trans('modules.plugins.maintenance-mode::maintenance-mode.enable_maintenance_mode'),
                ]);
        }

        $maintenanceMode->down($request);
        return $response
            ->setMessage(trans('modules.plugins.maintenance-mode::maintenance-mode.application_down'))
            ->setData([
                'is_down' => true,
                'notice'  => trans('modules.plugins.maintenance-mode::maintenance-mode.notice_enable'),
                'message' => trans('modules.plugins.maintenance-mode::maintenance-mode.disable_maintenance_mode'),
            ]);
    }
}
