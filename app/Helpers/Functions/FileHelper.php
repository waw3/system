<?php

if (! function_exists('view_finder')) {
    /**
     * extend app('view').
     *
     * @param  string  $view
     * @param  array   $data
     * @param  array   $mergeData
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    function view_finder()
    {
        return app('view')->getFinder();
    }
}


if (! function_exists('humanFilesize')) {
    function humanFilesize($size, $precision = 2)
    {
        $units = ['B','kB','MB','GB','TB','PB','EB','ZB','YB'];
        $step = 1024;
        $i = 0;

        while (($size / $step) > 0.9) {
            $size = $size / $step;
            $i++;
        }

        return round($size, $precision).$units[$i];
    }
}

/**
 * Checks if the uploaded document is an image
 */
if (! function_exists('isFileImage')) {
    function isFileImage($filename)
    {
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $array = ['png', 'PNG', 'jpg', 'JPG', 'jpeg', 'JPEG', 'gif', 'GIF'];
        $output = in_array($ext, $array) ? true : false;

        return $output;
    }
}

if (! function_exists('glob_recursive')) {
    /**
     * Find pathnames matching a pattern recursive.
     *
     * Recursive analog glob function.
     * Does not support flag GLOB_BRACE.
     * Possible should move to helpers file.
     *
     * @param $pattern
     * @param int $flags
     * @return array
     */
    function glob_recursive($pattern, $flags = 0)
    {
        $files = glob($pattern, $flags);

        foreach (glob(dirname($pattern) . '/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir) {
            $files = array_merge($files, glob_recursive($dir.'/'.basename($pattern), $flags));
        }

        return $files;
    }
}
