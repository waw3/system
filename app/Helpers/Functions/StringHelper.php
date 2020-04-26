<?php

use Illuminate\Support\Str;

if (! function_exists('str_contains')) {
    /**
     * Determine if a given string contains a given substring.
     *
     * @param  string  $haystack
     * @param  string|array  $needles
     * @return bool
     *
     * @deprecated Str::contains() should be used directly instead. Will be removed in Laravel 6.0.
     */
    function str_contains($haystack, $needles)
    {
        return Str::contains($haystack, $needles);
    }
}
