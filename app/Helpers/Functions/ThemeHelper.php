<?php

if (!function_exists('themes')) {

    function themes($path = '', $secure = null)
    {
        return Theme::assets($path, $secure);
    }
}


if (!function_exists('themeAsset')) {

    /**
     * themeAsset function.
     *
     * @access public
     * @param string $path (default: '')
     * @param mixed $secure (default: null)
     * @return void
     */
    function themeAsset($path = '', $secure = null)
    {
       return Theme::assets($path, $secure);
    }
}


if (!function_exists('theme_asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param  string  $path
     * @return string
     */
    function theme_asset($path, $secure = null)
    {
        $theme = app('themes')->getTheme();

        if ($theme && file_exists(public_path("themes/$theme/$path"))) {
            return app('url')->asset("themes/$theme/$path", $secure);
        }

        return app('url')->asset($path, $secure);
    }
}



if (!function_exists('theme_lang')) {

    function theme_lang($fallback)
    {
        return Theme::lang($fallback);
    }
}

if (!function_exists('secure_theme_asset')) {
    /**
     * Generate a secure asset path for the theme asset.
     *
     * @param  string  $path
     * @return string
     */
    function secure_theme_asset($path)
    {
        return theme_asset($path, true);
    }
}
