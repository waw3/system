<?php

if (! function_exists('intend')) {
    /**
     * Return redirect response.
     *
     * @param array $arguments
     * @param int   $status
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    function intend(array $arguments, int $status = 302)
    {
        $redirect = redirect(array_pull($arguments, 'url'), $status);

        if (request()->expectsJson()) {
            $response = collect($arguments['withErrors'] ?? $arguments['with']);

            return response()->json([$response->flatten()->first() ?? 'OK']);
        }

        foreach ($arguments as $key => $value) {
            $redirect = in_array($key, ['home', 'back']) ? $redirect->{$key}() : $redirect->{$key}($value);
        }

        return $redirect;
    }
}

if (! function_exists('domain')) {
    /**
     * Return domain host.
     *
     * @return string
     */
    function domain()
    {
        return parse_url(config('app.url'))['host'];
    }
}

if (!function_exists('packageAsset')) {
    function packageAsset($asset)
    {
        return asset('vendor/permissions/'.$asset);
    }
}

if (!function_exists('history')) {
    /**
     * Access the history facade anywhere.
     */
    function history()
    {
        return app('history');
    }
}

if (! function_exists('mconfig')) {

    /**
     * mconfig function.
     *
     * @access public
     * @param mixed $path
     * @return void
     */
    function mconfig($key = null, $default = null)
    {
        return config('modules.' . $key, $default);
    }
}

if (!function_exists('formatSize')) {

    /**
     * formatSize function.
     *
     * @access public
     * @param mixed $bytes
     * @return void
     */
    function formatSize($bytes)
    {
        $types = array('B', 'KB', 'MB', 'GB', 'TB');
        for ($i = 0; $bytes >= 1024 && $i < (count($types) - 1); $bytes /= 1024, $i++);
        return (round($bytes, 2) . " " . $types[$i]);
    }
}

if (! function_exists('constants')) {

    /**
     * constants function.
     *
     * @access public
     * @param mixed $key
     * @return void
     */
    function constants($key)
    {
        return config('constants.' . $key);
    }
}

if (! function_exists('ends_with')) {
    /**
     * Determine if a given string ends with a given substring.
     *
     * @param  string  $haystack
     * @param  string|array  $needles
     * @return bool
     *
     * @deprecated Str::endsWith() should be used directly instead. Will be removed in Laravel 6.0.
     */
    function ends_with($haystack, $needles)
    {
        return Str::endsWith($haystack, $needles);
    }
}

if (! function_exists('array_flatten')) {
    /**
     * Flatten a multi-dimensional array into a single level.
     *
     * @param  array  $array
     * @param  int  $depth
     * @return array
     *
     * @deprecated Arr::flatten() should be used directly instead. Will be removed in Laravel 6.0.
     */
    function array_flatten($array, $depth = INF)
    {
        return Arr::flatten($array, $depth);
    }
}

if ( ! function_exists('array_get'))
{
    /**
     * Get an item from an array using "dot" notation.
     *
     * @param  array   $array
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    function array_get($array, $key, $default = null)
    {
        if (is_null($key)) return $array;

        if (isset($array[$key])) return $array[$key];

        foreach (explode('.', $key) as $segment)
        {
            if ( ! is_array($array) || ! array_key_exists($segment, $array))
            {
                return value($default);
            }

            $array = $array[$segment];
        }

        return $array;
    }
}

if (! function_exists('studly_case')) {
    /**
     * Convert a value to studly caps case.
     *
     * @param  string  $value
     * @return string
     *
     * @deprecated Str::studly() should be used directly instead. Will be removed in Laravel 5.9.
     */
    function studly_case($value)
    {
        return Str::studly($value);
    }
}

if (! function_exists('title_case')) {
    /**
     * Convert a value to title case.
     *
     * @param  string  $value
     * @return string
     */
    function title_case($value)
    {
        return Str::title($value);
    }
}


if (! function_exists('starts_with')) {
    /**
     * Determine if a given string starts with a given substring.
     *
     * @param  string  $haystack
     * @param  string|array  $needles
     * @return bool
     *
     * @deprecated Str::startsWith() should be used directly instead. Will be removed in Laravel 5.9.
     */
    function starts_with($haystack, $needles)
    {
        return Str::startsWith($haystack, $needles);
    }
}



/**
 * return random color.
 *
 * @param int $userId
 *
 * @return string
 */
function getRandomColor($userId)
{
    $colors = ['329af0', 'fc6369', 'ffaa2e', '42c9af', '7d68f0'];
    $index = $userId % 5;

    return $colors[$index];
}

/**
 * @param string $datetime
 * @param bool   $full
 *
 * @throws Exception
 *
 * @return string
 */
function timeElapsedString($datetime, $full = false)
{
    $now = new DateTime();
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = [
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    ];
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k.' '.$v.($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) {
        $string = array_slice($string, 0, 1);
    }

    return $string ? implode(', ', $string).' ago' : 'just now';
}

/**
 * @param int $totalMinutes
 */
function roundToQuarterHour($totalMinutes)
{
    $hours = intval($totalMinutes / 60);
    $minutes = $totalMinutes % 60;
    if ($hours > 0) {
        printf('%02d:%02d h', $hours, $minutes);
    } else {
        printf('%02d:%02d m', $hours, $minutes);
    }
}

/**
 * @param int         $opacity
 * @param string|null $colorCode
 *
 * @return string
 */
function getColor($opacity = 1, $colorCode = null)
{
    if (empty($colorCode)) {
        $colorCode = getColorCode();
    }

    $color = substr($colorCode, 0, -1);
    $color .= ', '.$opacity.')';

    return $color;
}

/**
 * @param string $colorType
 * @param string $colorFormat
 *
 * @return array|string
 */
function getColorCode($colorType = 'bright', $colorFormat = 'rgbaCss')
{
    return RandomColor::one([
        'luminosity' => $colorType,
        'format'     => $colorFormat,
    ]);
}

/**
 * @param int $id
 *
 * @return array|string
 */
function getColorRGBCode($id)
{
    $colorCodes = [
        'rgba(239, 222, 205)',
        'rgba(205, 149, 117)',
        'rgba(253, 217, 181)',
        'rgba(120, 219, 226)',
        'rgba(135, 169, 107)',
        'rgba(255, 164, 116)',
        'rgba(250, 231, 181)',
        'rgba(159, 129, 112)',
        'rgba(253, 124, 110)',
        'rgba(0,0,0)',
        'rgba(172, 229, 238)',
        'rgba(31, 117, 254)',
        'rgba(162, 162, 208)',
        'rgba(102, 153, 204)',
        'rgba(13, 152, 186)',
        'rgba(115, 102, 189)',
        'rgba(222, 93, 131)',
        'rgba(203, 65, 84)',
        'rgba(180, 103, 77)',
        'rgba(255, 127, 73)',
        'rgba(234, 126, 93)',
        'rgba(176, 183, 198)',
        'rgba(255, 255, 153)',
        'rgba(28, 211, 162)',
        'rgba(255, 170, 204)',
        'rgba(221, 68, 146)',
        'rgba(29, 172, 214)',
        'rgba(188, 93, 88)',
        'rgba(221, 148, 117)',
        'rgba(154, 206, 235)',
        'rgba(255, 188, 217)',
        'rgba(253, 219, 109)',
        'rgba(43, 108, 196)',
        'rgba(239, 205, 184)',
        'rgba(110, 81, 96)',
        'rgba(206, 255, 29)',
        'rgba(113, 188, 120)',
        'rgba(109, 174, 129)',
        'rgba(195, 100, 197)',
        'rgba(204, 102, 102)',
        'rgba(231, 198, 151)',
        'rgba(252, 217, 117)',
        'rgba(168, 228, 160)',
        'rgba(149, 145, 140)',
        'rgba(28, 172, 120)',
        'rgba(17, 100, 180)',
        'rgba(240, 232, 145)',
        'rgba(255, 29, 206)',
        'rgba(178, 236, 93)',
        'rgba(93, 118, 203)',
        'rgba(202, 55, 103)',
        'rgba(59, 176, 143)',
        'rgba(254, 254, 34)',
        'rgba(252, 180, 213)',
        'rgba(255, 244, 79)',
        'rgba(255, 189, 136)',
        'rgba(246, 100, 175)',
        'rgba(170, 240, 209)',
        'rgba(205, 74, 76)',
        'rgba(237, 209, 156)',
        'rgba(151, 154, 170)',
        'rgba(255, 130, 67)',
        'rgba(200, 56, 90)',
        'rgba(239, 152, 170)',
        'rgba(253, 188, 180)',
        'rgba(26, 72, 118)',
        'rgba(48, 186, 143)',
        'rgba(197, 75, 140)',
        'rgba(25, 116, 210)',
        'rgba(255, 163, 67)',
        'rgba(186, 184, 108)',
        'rgba(255, 117, 56)',
        'rgba(255, 43, 43)',
        'rgba(248, 213, 104)',
        'rgba(230, 168, 215)',
        'rgba(65, 74, 76)',
        'rgba(255, 110, 74)',
        'rgba(28, 169, 201)',
        'rgba(255, 207, 171)',
        'rgba(197, 208, 230)',
        'rgba(253, 221, 230)',
        'rgba(21, 128, 120)',
        'rgba(252, 116, 253)',
        'rgba(247, 143, 167)',
        'rgba(142, 69, 133)',
        'rgba(116, 66, 200)',
        'rgba(157, 129, 186)',
        'rgba(254, 78, 218)',
        'rgba(255, 73, 108)',
        'rgba(214, 138, 89)',
        'rgba(113, 75, 35)',
        'rgba(255, 72, 208)',
        'rgba(227, 37, 107)',
        'rgba(238,32 ,77 )',
        'rgba(255, 83, 73)',
        'rgba(192, 68, 143)',
        'rgba(31, 206, 203)',
        'rgba(120, 81, 169)',
        'rgba(255, 155, 170)',
        'rgba(252, 40, 71)',
        'rgba(118, 255, 122)',
        'rgba(159, 226, 191)',
        'rgba(165, 105, 79)',
        'rgba(138, 121, 93)',
        'rgba(69, 206, 162)',
        'rgba(251, 126, 253)',
        'rgba(205, 197, 194)',
        'rgba(128, 218, 235)',
        'rgba(236, 234, 190)',
        'rgba(255, 207, 72)',
        'rgba(253, 94, 83)',
        'rgba(250, 167, 108)',
        'rgba(24, 167, 181)',
        'rgba(235, 199, 223)',
        'rgba(252, 137, 172)',
        'rgba(219, 215, 210)',
        'rgba(23, 128, 109)',
        'rgba(222, 170, 136)',
        'rgba(119, 221, 231)',
        'rgba(255, 255, 102)',
        'rgba(146, 110, 174)',
        'rgba(50, 74, 178)',
        'rgba(247, 83, 148)',
        'rgba(255, 160, 137)',
        'rgba(143, 80, 157)',
        'rgba(255, 255, 255)',
        'rgba(162, 173, 208)',
        'rgba(255, 67, 164)',
        'rgba(252, 108, 133)',
        'rgba(205, 164, 222)',
        'rgba(252, 232, 131)',
        'rgba(197, 227, 132)',
        'rgba(255, 174, 66)',
    ];
    $index = $id % 132;

    return $colorCodes[$index];
}
