<?php

use Modules\Theme\Facades\AdminBarFacade;
use Modules\Theme\Facades\ThemeOptionFacade;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

if (!function_exists('sanitize_html_class')) {
    /**
     * @param $class
     * @param string $fallback
     * @return mixed
     */
    function sanitize_html_class($class, $fallback = '')
    {
        //Strip out any % encoded octets
        $sanitized = preg_replace('|%[a-fA-F0-9][a-fA-F0-9]|', '', $class);

        //Limit to A-Z,a-z,0-9,_,-
        $sanitized = preg_replace('/[^A-Za-z0-9_-]/', '', $sanitized);

        if ('' == $sanitized && $fallback) {
            return sanitize_html_class($fallback);
        }
        /**
         * Filters a sanitized HTML class string.
         *
         * @param string $sanitized The sanitized HTML class.
         * @param string $class HTML class before sanitization.
         * @param string $fallback The fallback string.
         * @since 2.8.0
         *
         */
        return apply_filters('sanitize_html_class', $sanitized, $class, $fallback);
    }
}

if (!function_exists('parse_args')) {
    /**
     * @param $args
     * @param string $defaults
     * @return array
     */
    function parse_args($args, $defaults = '')
    {
        if (is_object($args)) {
            $result = get_object_vars($args);
        } else {
            $result =& $args;
        }

        if (is_array($defaults)) {
            return array_merge($defaults, $result);
        }

        return $result;
    }
}

if (!function_exists('theme')) {
    /**
     * Get the theme instance.
     *
     * @param  string $themeName
     * @param  string $layoutName
     * @return Theme
     * @throws FileNotFoundException
     */
    function theme($themeName = null, $layoutName = null)
    {
        $theme = app('theme');

        if ($themeName) {
            $theme->theme($themeName);
        }

        if ($layoutName) {
            $theme->layout($layoutName);
        }
        return $theme;
    }
}

if (!function_exists('theme_option')) {
    /**
     * @return mixed
     *
     */
    function theme_option($key = null, $default = '')
    {
        if (!empty($key)) {
            try {
                return ThemeOption::getOption($key, $default);
            } catch (FileNotFoundException $exception) {
                info($exception->getMessage());
            }
        }

        return ThemeOptionFacade::getFacadeRoot();
    }
}


if (!function_exists('themes_path')) {
    /**
     * Get the path to the themes folder.
     *
     * @param  string  $path
     * @return string
     */
    function themes_path($path = '')
    {
        return app()->themesPath($path);
    }
}
if (!function_exists('theme_path')) {

    /**
     * theme_path function. active theme path
     *
     * @access public
     * @param string $path (default: '')
     * @return void
     */
    function theme_path($path = '')
    {

        return themes_path($path);

    }
}



if (!function_exists('admin_bar')) {
    /**
     * @return Modules\Theme\Supports\AdminBar
     */
    function admin_bar()
    {
        return AdminBarFacade::getFacadeRoot();
    }
}
