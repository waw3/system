<?php

use Modules\Dashboard\Facades\DashboardMenu;
use Modules\Base\Facades\PageTitleFacade;
use Modules\Base\Supports\Editor;
use Modules\Base\Supports\PageTitle;

if (!function_exists('table_actions')) {
    /**
     * @param string $edit
     * @param string $delete
     * @param $item
     * @param string $extra
     * @return string
     * @throws Throwable
     */
    function table_actions($edit, $delete, $item, $extra = null): string
    {
        return view('modules.base::elements.tables.actions', compact('edit', 'delete', 'item', 'extra'))->render();
    }
}

if (!function_exists('anchor_link')) {
    /**
     * @param string $link
     * @param string $name
     * @param array $options
     * @return string
     *
     * @throws Throwable
     */
    function anchor_link(string $link, string $name, array $options = []): string
    {
        $options = Html::attributes($options);

        return view('modules.base::elements.tables.link', compact('link', 'name', 'options'))->render();
    }
}

if (!function_exists('table_checkbox')) {
    /**
     * @param int $id
     * @return string
     *
     * @throws Throwable
     */
    function table_checkbox($id): string
    {
        return view('modules.base::elements.tables.checkbox', compact('id'))->render();
    }
}

if (!function_exists('language_flag')) {
    /**
     * @param string $flag
     * @param string $name
     *
     * @return string
     */
    function language_flag(string $flag, ?string $name = null): string
    {
        return Html::image(url(BASE_LANGUAGE_FLAG_PATH . $flag . '.svg'), $name, ['title' => $name, 'width' => 16]);
    }
}

if (!function_exists('render_editor')) {
    /**
     * @param string $name
     * @param null $value
     * @param bool $withShortCode
     * @param array $attributes
     * @return string
     *
     * @throws Throwable
     */
    function render_editor(string $name, ?string $value = null, $withShortCode = false, array $attributes = []): string
    {
        $editor = new Editor;

        return $editor->render($name, $value, $withShortCode, $attributes);
    }
}

if (!function_exists('is_in_admin')) {
    /**
     * @return bool
     */
    function is_in_admin(): bool
    {
        $isInAdmin = request()->segment(1) === mconfig('base.config.admin_dir');

        return apply_filters(IS_IN_ADMIN_FILTER, $isInAdmin);
    }
}

if (!function_exists('page_title')) {
    /**
     * @return PageTitle
     */
    function page_title()
    {
        return PageTitleFacade::getFacadeRoot();
    }
}

if (!function_exists('dashboard_menu')) {
    /**
     * @return \Modules\Dashboard\Supports\DashboardMenu
     */
    function dashboard_menu()
    {
        return DashboardMenu::getFacadeRoot();
    }
}

if (!function_exists('html_attribute_element')) {
    /**
     * @param $key
     * @param $value
     * @return string
     */
    function html_attribute_element($key, $value)
    {
        if (is_numeric($key)) {
            return $value;
        }

        // Treat boolean attributes as HTML properties
        if (is_bool($value) && $key != 'value') {
            return $value ? $key : '';
        }

        if (!empty($value)) {
            return $key . '="' . e($value) . '"';
        }

        return '';
    }
}

if (!function_exists('html_attributes_builder')) {
    /**
     * @param array $attributes
     * @return string
     */
    function html_attributes_builder(array $attributes): string
    {
        $html = [];

        foreach ((array)$attributes as $key => $value) {
            $element = html_attribute_element($key, $value);

            if (!empty($element)) {
                $html[] = $element;
            }
        }

        return count($html) > 0 ? ' ' . implode(' ', $html) : '';
    }
}

if (!function_exists('get_cms_version')) {
    /**
     * @return string
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    function get_cms_version(): string
    {
        try {
            return trim(get_file_data(base_path('Modules/VERSION'), false));
        } catch (Exception $exception) {
            return '5.2';
        }
    }
}

if (!function_exists('platform_path')) {
    /**
     * @return string
     */
    function platform_path($path = null): string
    {
        return base_path('platform/' . $path);
    }
}



if (!function_exists('package_path')) {
    /**
     * @return string
     */
    function package_path($path = null): string
    {
        return platform_path('packages/' . $path);
    }
}
