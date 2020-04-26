<?php

return [

    /**
     * getRoutesList function.
     *
     * @access public
     * @return void
     */
    'getRoutesList' => function () {
        $routes = collect(Route::getRoutes())->map(function ($route) {
            return [
                'host'   => $route->domain(),
                'method' => implode('|', $route->methods()),
                'uri'    => $route->uri(),
                'name'   => $route->getName(),
                'action' => $route->getActionName(),
            ];
        });
        return $routes;
    },

    /**
     * view function.
     *
     * @access public
     * @param mixed $url
     * @param mixed $view
     * @param mixed $data (default: [])
     * @param array $mergeData (default: [])
     * @return void
     */
    'view' => function ($url, $view, $data = [], array $mergeData = []) {
        return Route::any($url, '\App\Macros\Routes\RouteMacros@view')->defaults('view', compact('view', 'data', 'mergeData'));
    },

    /**
     * redirect function.
     *
     * @access public
     * @param mixed $url
     * @param mixed $route
     * @param mixed $parameters (default: [])
     * @param int $status (default: 302)
     * @param mixed $headers (default: [])
     * @return void
     */
    'redirect' => function ($url, $route, $parameters = [], $status = 302, $headers = []) {
        return $this->get($url, function () use ($route, $parameters, $status, $headers) {
            return redirect()->route($route, $parameters, $status, $headers);
        });
    },

    /**
     * file function.
     *
     * @access public
     * @param mixed $url
     * @param mixed $file
     * @param array $headers (default: [])
     * @return void
     */
    'file' => function ($url, $file, array $headers = []) {
        return Route::any($url, '\App\Macros\Routes\RouteMacros@file')->defaults('file', compact('file', 'headers'));
    },

    /**
     * json function.
     *
     * @access public
     * @param mixed $url
     * @param mixed $data
     * @param int $status (default: 200)
     * @param array $headers (default: [])
     * @param int $options (default: 0)
     * @return void
     */
    'json' => function ($url, $data, $status = 200, array $headers = [], $options = 0) {
        return Route::any($url, '\App\Macros\Routes\RouteMacros@json')->defaults('json', compact('data', 'status', 'headers', 'options'));
    },


    /**
     * download function.
     *
     * @access public
     * @param mixed $url
     * @param mixed $file
     * @param mixed $name (default: null)
     * @param array $headers (default: [])
     * @param string $disposition (default: 'attachment')
     * @return void
     */
    'download' => function ($url, $file, $name = null, array $headers = [], $disposition = 'attachment') {
        return Route::any($url, '\App\Macros\Routes\RouteMacros@download')->defaults('download', compact('file', 'name', 'headers', 'disposition'));
    },

    /**
     * redirect function.
     *
     * @access public
     * @param mixed $url
     * @param mixed $to
     * @param int $status (default: 302)
     * @param array $headers (default: [])
     * @param mixed $secure (default: null)
     * @return void
     */
    'redirect' => function ($url, $to, $status = 302, array $headers = [], $secure = null) {
        return Route::any($url, '\App\Macros\Routes\RouteMacros@redirect')->defaults('redirection', compact('to', 'status', 'headers', 'secure'));
    },

    /**
     * blacklist function.
     *
     * @access public
     * @param mixed $group (default: null)
     * @return void
     */
    'blacklist' => function ($group = null) {
        return RouteJs::blacklist($this, $group);
    },

    /**
     * whitelist function.
     *
     * @access public
     * @param mixed $group (default: null)
     * @return void
     */
    'whitelist' => function ($group = null) {
        return RouteJs::whitelist($this, $group);
    },

    /**
     * breadcrumbIndex function.
     *
     * @access public
     * @param mixed $title
     * @return void
     */
    'breadcrumbIndex' => function ($title) {
        $this->action['breadcrumbIndex'] = true;
        $this->action['breadcrumb'] = $title;
        return $this;
    },

    /**
     * breadcrumb function.
     *
     * @access public
     * @param mixed $title
     * @return void
     */
    'breadcrumb' => function ($title) {
        $this->action['breadcrumb'] = $title;
        return $this;
    },

    /**
     * breadcrumbGroup function.
     *
     * @access public
     * @param mixed $title
     * @return void
     */
    'breadcrumbGroup' => function ($title) {
        $this->action['breadcrumbGroup'] = true;
        $this->action['breadcrumb'] = $title;
        return $this;
    },

    /**
     * breadcrumbCollection function.
     *
     * @access public
     * @param string $collection
     * @return void
     */
    'breadcrumbCollection' => function (string $collection) {
        $this->action['breadcrumbCollection'] = $collection;
        return $this;
    },

     /**
      * module function.
      *
      * @access public
      * @param mixed $module
      * @param mixed $only (default: [])
      * @param mixed $options (default: [])
      * @return void
      */
    'module' => function ($module, $only = [], $options = []) {
        $onlyOptions = count($only) ? ['only' => $only] : [];
        $controllerNameArray = collect(explode('.', $module))->map(function ($name) {
            return studly_case($name);
        });
        $lastName = $controllerNameArray->pop();
        $controllerName = $controllerNameArray->map(function ($name) {
            return str_singular($name);
        })->push($lastName)->push('Controller')->implode('');
        Router::resource($module, $controllerName, array_merge($onlyOptions, $options));
    },

    /**
     * admin function.
     *
     * @access public
     * @param mixed $module
     * @return void
     */
    'admin' => function ($module) {

/*
        $url        = str_replace('.', '', Str::plural($module));
        $name       = 'admin.' . Str::singular($module);
        $controller = Str::studly(str_replace('.', ' ', $module)) . 'Controller';

        Router::middleware(['auth'])->namespace('Settings')->prefix('admin')->name('admin.')group( function () use ($url, $name, $controller) {
            Router::get($url . '/show', $controller . '@show')->name('show');
            Router::get($url . '/edit', $controller . '@edit')->name('edit');
            Router::put($url . '/update', $controller . '@update')->name('update');
            Router::delete($url . '/delete', $controller . '@destroy')->name('destroy');
        });
*/
        },

];
