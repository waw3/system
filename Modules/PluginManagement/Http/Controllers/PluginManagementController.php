<?php

namespace Modules\PluginManagement\Http\Controllers;

use Assets;
use Modules\Base\Supports\Helper;
use Modules\PluginManagement\Console\Commands\PluginActivateCommand;
use Modules\PluginManagement\Console\Commands\PluginDeactivateCommand;
use Modules\PluginManagement\Console\Commands\PluginRemoveCommand;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Exception;
use File;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;

class PluginManagementController extends Controller
{

    /**
     * index function. Show all plugins in system
     *
     * @access public
     * @throws FileNotFoundException
     * @return void
     */
    public function index()
    {
        page_title()->setTitle(trans('modules.pluginmanagement::plugin.plugins'));

        Assets::addScriptsDirectly('vendor/core/packages/plugin-management/js/plugin.js')->addStylesDirectly('vendor/core/packages/plugin-management/css/plugin.css');

        $list = [];

        if (File::exists(plugin_path('.DS_Store'))) {
            File::delete(plugin_path('.DS_Store'));
        }

        $plugins = scan_folder(plugin_path());
        if (!empty($plugins)) {
            $installed = get_active_plugins();
            foreach ($plugins as $plugin) {
                if (File::exists(plugin_path($plugin . '/.DS_Store'))) {
                    File::delete(plugin_path($plugin . '/.DS_Store'));
                }

                $pluginPath = plugin_path($plugin);
                if (!File::isDirectory($pluginPath) || !File::exists($pluginPath . '/plugin.json')) {
                    continue;
                }

                $content = get_file_data($pluginPath . '/plugin.json');
                if (!empty($content)) {
                    if (!in_array($plugin, $installed)) {
                        $content['status'] = 0;
                    } else {
                        $content['status'] = 1;
                    }

                    $content['path'] = $plugin;
                    $content['image'] = null;
                    if (File::exists($pluginPath . '/screenshot.png')) {
                        $content['image'] = base64_encode(File::get($pluginPath . '/screenshot.png'));
                    }
                    $list[] = (object)$content;
                }
            }
        }

        return view('modules.pluginmanagement::index', compact('list'));
    }

    /**
     * update function. Activate or Deactivate plugin
     *
     * @access public
     * @param Request $request
     * @param BaseHttpResponse $response
     * @param PluginActivateCommand $pluginActivateCommand
     * @param PluginDeactivateCommand $pluginDeactivateCommand
     * @return mixed
     */
    public function update(Request $request, BaseHttpResponse $response, PluginActivateCommand $pluginActivateCommand, PluginDeactivateCommand $pluginDeactivateCommand)
    {
        $plugin = strtolower($request->input('name'));

        $content = get_file_data(plugin_path($plugin . '/plugin.json'));
        if (!empty($content)) {
            try {
                $activatedPlugins = get_active_plugins();
                if (!in_array($plugin, $activatedPlugins)) {
                    if (!empty(Arr::get($content, 'require'))) {
                        $count_required_plugins = count(array_intersect($content['require'], $activatedPlugins));
                        $valid = $count_required_plugins == count($content['require']);
                        if (!$valid) {
                            return $response
                                ->setError()
                                ->setMessage(trans('modules.pluginmanagement::plugin.missing_required_plugins', [
                                    'plugins' => implode(',', $content['require']),
                                ]));
                        }
                    }

                    Helper::executeCommand($pluginActivateCommand->getName(), ['name' => $plugin]);
                } else {
                    Helper::executeCommand($pluginDeactivateCommand->getName(), ['name' => $plugin]);
                }

                return $response->setMessage(trans('modules.pluginmanagement::plugin.update_plugin_status_success'));
            } catch (Exception $ex) {
                return $response->setError()->setMessage($ex->getMessage());
            }
        }

        return $response->setError()->setMessage(trans('modules.pluginmanagement::plugin.invalid_plugin'));
    }

    /**
     * Remove plugin
     *
     * @param BaseHttpResponse $response
     * @param PluginRemoveCommand $pluginRemoveCommand
     * @return BaseHttpResponse
     */
    public function destroy($plugin, BaseHttpResponse $response, PluginRemoveCommand $pluginRemoveCommand)
    {
        $plugin = strtolower($plugin);

        if (in_array($plugin, scan_folder(plugin_path()))) {
            try {
                Helper::executeCommand($pluginRemoveCommand->getName(), ['name' => $plugin, '--force' => true]);
                return $response->setMessage(trans('modules.pluginmanagement::plugin.remove_plugin_success'));
            } catch (Exception $ex) {
                return $response
                    ->setError()
                    ->setMessage($ex->getMessage());
            }
        }

        return $response
            ->setError()
            ->setMessage(trans('modules.pluginmanagement::plugin.invalid_plugin'));
    }
}
