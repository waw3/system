<?php

namespace Modules\Theme\Http\Controllers;

use Assets;
use Modules\Base\Forms\FormBuilder;
use Modules\Base\Http\Controllers\BaseController;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Base\Supports\Helper;
use Modules\Setting\Supports\SettingStore;
use Modules\Theme\Commands\ThemeActivateCommand;
use Modules\Theme\Commands\ThemeRemoveCommand;
use Modules\Theme\Forms\CustomCSSForm;
use Modules\Theme\Http\Requests\CustomCssRequest;
use Exception;
use File;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;
use ThemeOption;

class ThemeController extends BaseController
{
    /**
     * @return Factory|View
     */
    public function index()
    {
        page_title()->setTitle(trans('modules.theme::theme.theme'));

        if (File::exists(theme_path('.DS_Store'))) {
            File::delete(theme_path('.DS_Store'));
        }

        Assets::addScriptsDirectly('vendor/core/packages/theme/js/theme.js');

        return view('modules.theme::list');
    }

    /**
     * @return Factory|View
     */
    public function getOptions()
    {
        page_title()->setTitle(trans('modules.theme::theme.theme_options'));

        Assets::addScripts(['bootstrap-tagsinput', 'typeahead', 'are-you-sure', 'colorpicker'])
            ->addStyles(['bootstrap-tagsinput', 'colorpicker'])
            ->addStylesDirectly([
                'vendor/core/libraries/fontawesome-iconpicker/css/fontawesome-iconpicker.min.css',
                'vendor/core/libraries/fontselect/fontselect-default.css',
            ])
            ->addScriptsDirectly([
                'vendor/core/libraries/fontawesome-iconpicker/js/fontawesome-iconpicker.min.js',
                'vendor/core/libraries/fontselect/jquery.fontselect.min.js',
                'vendor/core/packages/theme/js/theme-options.js',
            ]);

        return view('modules.theme::options');
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @param SettingStore $settingStore
     * @return BaseHttpResponse
     * @throws FileNotFoundException
     */
    public function postUpdate(Request $request, BaseHttpResponse $response, SettingStore $settingStore)
    {
        $sections = ThemeOption::constructSections();
        foreach ($sections as $section) {
            foreach ($section['fields'] as $field) {
                $key = $field['attributes']['name'];
                ThemeOption::setOption($key, $request->input($key, 0));
            }
        }
        $settingStore->save();

        return $response->setMessage(trans('modules.base::notices.update_success_message'));
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @param ThemeActivateCommand $themeActivateCommand
     * @return BaseHttpResponse
     * @throws Exception
     */
    public function postActivateTheme(
        Request $request,
        BaseHttpResponse $response,
        ThemeActivateCommand $themeActivateCommand
    ) {
        Helper::executeCommand($themeActivateCommand->getName(), ['name' => $request->input('theme')]);

        return $response
            ->setMessage(trans('modules.theme::theme.active_success'));
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function getCustomCss(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('modules.theme::theme.custom_css'));

        Assets::addStylesDirectly([
            'vendor/core/libraries/codemirror/lib/codemirror.css',
            'vendor/core/libraries/codemirror/addon/hint/show-hint.css',
            'vendor/core/packages/theme/css/custom-css.css',
        ])
            ->addScriptsDirectly([
                'vendor/core/libraries/codemirror/lib/codemirror.js',
                'vendor/core/libraries/codemirror/lib/css.js',
                'vendor/core/libraries/codemirror/addon/hint/show-hint.js',
                'vendor/core/libraries/codemirror/addon/hint/anyword-hint.js',
                'vendor/core/libraries/codemirror/addon/hint/css-hint.js',
                'vendor/core/packages/theme/js/custom-css.js',
            ]);

        return $formBuilder->create(CustomCSSForm::class)->renderForm();
    }

    /**
     * @param CustomCssRequest $request
     * @param BaseHttpResponse $response
     * @param SettingStore $setting
     * @return BaseHttpResponse
     */
    public function postCustomCss(CustomCssRequest $request, BaseHttpResponse $response, SettingStore $setting)
    {
        $file = public_path(mconfig('theme.config.themeDir') . '/' . $setting->get('theme') . '/css/style.integration.css');
        $css = $request->input('custom_css');
        $css = htmlspecialchars(htmlentities(strip_tags($css)));
        save_file_data($file, $css, false);

        return $response->setMessage(__('Update custom CSS successfully!'));
    }

    /**
     * Remove theme
     *
     * @param Request $request
     * @param BaseHttpResponse $response
     * @param ThemeRemoveCommand $themeRemoveCommand
     * @return mixed
     */
    public function postRemoveTheme(
        Request $request,
        BaseHttpResponse $response,
        ThemeRemoveCommand $themeRemoveCommand
    ) {
        $theme = strtolower($request->input('theme'));

        if (in_array($theme, scan_folder(theme_path()))) {
            try {
                Helper::executeCommand($themeRemoveCommand->getName(), ['name' => $theme, '--force' => true]);
                return $response->setMessage(trans('modules.theme::theme.remove_theme_success'));
            } catch (Exception $ex) {
                info($ex->getMessage());
                return $response
                    ->setError()
                    ->setMessage($ex->getMessage());
            }
        }

        return $response
            ->setError()
            ->setMessage(trans('modules.theme::theme.theme_is_note_existed'));
    }
}
