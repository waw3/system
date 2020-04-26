<?php

namespace Modules\Base\Http\Controllers;

use Assets, Exception, Throwable;
use Modules\Acl\Models\UserMeta;
use Modules\Base\Console\Commands\ClearLogCommand;
use BaseHttpResponse;
use Modules\Base\Supports\Helper;
use Modules\Base\Supports\MembershipAuthorization;
use Modules\Base\Supports\SystemManagement;
use Modules\Base\Tables\InfoTable;
use Modules\Table\Services\TableBuilder;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SystemController extends Controller
{

    /**
     * @return Factory|View
     *
     * @throws Throwable
     */
    public function getInfo(Request $request, TableBuilder $tableBuilder)
    {
        page_title()->setTitle(trans('modules.base::system.info.title'));

        Assets::addScriptsDirectly('vendor/core/js/system-info.js')
            ->addStylesDirectly(['vendor/core/css/system-info.css']);

        $composerArray = SystemManagement::getComposerArray();
        $packages = SystemManagement::getPackagesAndDependencies($composerArray['require']);

        $infoTable = $tableBuilder->create(InfoTable::class);

        if ($request->expectsJson()) {
            return $infoTable->renderTable();
        }

        $systemEnv = SystemManagement::getSystemEnv();
        $serverEnv = SystemManagement::getServerEnv();

        return view('modules.base::system.info', compact(
            'packages',
            'infoTable',
            'systemEnv',
            'serverEnv'
        ));
    }

    /**
     * @return Factory|View
     */
    public function getCacheManagement()
    {
        page_title()->setTitle(trans('modules.base::cache.cache_management'));
        Assets::addScriptsDirectly('vendor/core/js/cache.js');

        return view('modules.base::system.cache');
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @param ClearLogCommand $clearLogCommand
     * @return BaseHttpResponse
     * @throws Exception
     */
    public function postClearCache(Request $request, BaseHttpResponse $response, ClearLogCommand $clearLogCommand)
    {
        if (function_exists('proc_open')) {
            switch ($request->input('type')) {
                case 'clear_cms_cache':
                    Helper::executeCommand('cache:clear');
                    break;
                case 'refresh_compiled_views':
                    Helper::executeCommand('view:clear');
                    break;
                case 'clear_config_cache':
                    Helper::executeCommand('config:clear');
                    break;
                case 'clear_route_cache':
                    Helper::executeCommand('route:clear');
                    break;
                case 'clear_log':
                    Helper::executeCommand($clearLogCommand->getName());
                    break;
            }
        }

        return $response->setMessage(trans('modules.base::cache.commands.' . $request->input('type') . '.success_msg'));
    }

    /**
     * @param MembershipAuthorization $authorization
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function authorize(MembershipAuthorization $authorization, BaseHttpResponse $response)
    {
        $authorization->authorize();

        return $response;
    }

    /**
     * @param string $lang
     * @param Request $request
     * @return RedirectResponse
     * @throws Exception
     */
    public function getLanguage($lang, Request $request)
    {
        if ($lang != false && array_key_exists($lang, Assets::getAdminLocales())) {
            if (Auth::check()) {
                UserMeta::setMeta('site-locale', $lang);
                cache()->forget(md5('cache-dashboard-menu-' . $request->user()->getKey()));
            }
            session()->put('site-locale', $lang);
        }

        return redirect()->back();
    }
}
