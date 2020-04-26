<?php

if (! function_exists('file_build_path')) {
    /**
     * Builds a file path with the appropriate directory separator.
     *
     * @return string
     */
    function file_build_path()
    {
        return implode(DIRECTORY_SEPARATOR, func_get_args());
    }
}


if (!function_exists('domain_route')) {
    /**
     * Generate the URL to a named route.
     * This is a modified version of Laravel's route() function
     * Pass subdomain value automatically
     *
     * @param  array|string $name
     * @param  mixed $parameters
     * @param  bool $absolute
     * @return string
     */
    function domain_route($name, $parameters = [], $absolute = true)
    {
        $parameters['subdomain'] = request()->route('subdomain');
        return app('url')->route($name, $parameters, $absolute);
    }
}

if (!function_exists('getRouteUrl')) {
    /**
     * Converts querystring params to array and use it as route params and returns URL.
     */
    function getRouteUrl($url, $url_type = 'route', $separator = '?')
    {
        $routeUrl = '';
        if (!empty($url)) {
            if ($url_type == 'route') {
                if (strpos($url, $separator) !== false) {
                    $urlArray = explode($separator, $url);
                    $url = $urlArray[0];
                    parse_str($urlArray[1], $params);
                    $routeUrl = route($url, $params);
                } else {
                    $routeUrl = route($url);
                }
            } else {
                $routeUrl = $url;
            }
        }

        return $routeUrl;
    }
}




if (! function_exists('routeIs')) {

    /**
     * routeIs function.
     *
     * @access public
     * @param bool $key (default: false)
     * @return void
     */
    function routeIs($arg, $class = null)
    {
        return \Route::is($arg) ? (!is_null($class) ? $class : true) : false;
    }
}
