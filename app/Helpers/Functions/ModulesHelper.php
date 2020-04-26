<?php


if (! function_exists('models_path')) {
    /**
     * Get the models path.
     *
     * @param  string  $path
     * @return string
     */
    function models_path($path = '')
    {
        return app()->modelsPath($path);
    }
}

if (! function_exists('models_path')) {
    /**
     * Get the models path.
     *
     * @param  string  $path
     * @return string
     */
    function models_path($path = '')
    {
        return app()->modelsPath($path);
    }
}

if (! function_exists('module_path')) {

    /**
     * module_path function.
     *
     * @access public
     * @param mixed $name
     * @return void
     */
    function module_path($name)
    {
        $module = module($name);

        return $module->getPath();
    }
}

if (! function_exists('module')) {

    /**
     * module function.
     *
     * @access public
     * @param mixed $name
     * @return void
     */
    function module($name)
    {
        return app('modules')->find($name);
    }
}

if (! function_exists('modules_path')) {

    /**
     * modules_path function.
     *
     * @access public
     * @param string $path (default: '')
     * @return void
     */
    function modules_path($path = '')
    {
        return app()->modulesPath($path);
    }
}
