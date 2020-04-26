<?php

if (! function_exists('transHas')) {

    /**
     * transHas function.
     *
     * @access public
     * @param mixed $key
     * @param mixed $locale (default: null)
     * @param bool $fallback (default: true)
     * @return void
     */
    function transHas($key, $locale = null, $fallback = true)
    {
        return \Illuminate\Support\Facades\Lang::has($key, $locale);
    }
}
