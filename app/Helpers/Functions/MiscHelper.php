<?php

use Carbon\Carbon;

if (! function_exists('camelcase_to_word')) {
    /**
     * camelcase_to_word function.
     *
     * @access public
     * @param mixed $str
     * @return string
     */
    function camelcase_to_word($str)
    {
        return implode(' ', preg_split('/
          (?<=[a-z])
          (?=[A-Z])
        | (?<=[A-Z])
          (?=[A-Z][a-z])
        /x', $str));
    }
}

if (!function_exists('money_format')) {

    /**
     * money_format function.
     *
     * @access public
     * @param mixed $format
     * @param mixed $number
     * @return void
     */
    function money_format($format, $number)
    {
        $regex = '/%((?:[\^!\-]|\+|\(|\=.)*)([0-9]+)?' .
            '(?:#([0-9]+))?(?:\.([0-9]+))?([in%])/';

        if (setlocale(LC_MONETARY, 0) == 'C') {
            setlocale(LC_MONETARY, '');
        }

        $locale = localeconv();

        preg_match_all($regex, $format, $matches, PREG_SET_ORDER);

        foreach ($matches as $fmatch) {
            $value = floatval($number);

            $flags = array(
                'fillchar' => preg_match('/\=(.)/', $fmatch[1], $match) ?
                    $match[1] : ' ',
                'nogroup' => preg_match('/\^/', $fmatch[1]) > 0,
                'usesignal' => preg_match('/\+|\(/', $fmatch[1], $match) ?
                    $match[0] : '+',
                'nosimbol' => preg_match('/\!/', $fmatch[1]) > 0,
                'isleft' => preg_match('/\-/', $fmatch[1]) > 0
            );

            $width = trim($fmatch[2]) ? (int)$fmatch[2] : 0;
            $left = trim($fmatch[3]) ? (int)$fmatch[3] : 0;
            $right = trim($fmatch[4]) ? (int)$fmatch[4] : $locale['int_frac_digits'];
            $conversion = $fmatch[5];

            $positive = true;

            if ($value < 0) {
                $positive = false;
                $value *= -1;
            }

            $letter = $positive ? 'p' : 'n';
            $prefix = $suffix = $cprefix = $csuffix = $signal = '';

            $signal = $positive ? $locale['positive_sign'] : $locale['negative_sign'];

            switch (true) {
                case $locale["{$letter}_sign_posn"] == 1 && $flags['usesignal'] == '+':
                    $prefix = $signal;
                    break;
                case $locale["{$letter}_sign_posn"] == 2 && $flags['usesignal'] == '+':
                    $suffix = $signal;
                    break;
                case $locale["{$letter}_sign_posn"] == 3 && $flags['usesignal'] == '+':
                    $cprefix = $signal;
                    break;
                case $locale["{$letter}_sign_posn"] == 4 && $flags['usesignal'] == '+':
                    $csuffix = $signal;
                    break;
                case $flags['usesignal'] == '(':
                case $locale["{$letter}_sign_posn"] == 0:
                    $prefix = '(';
                    $suffix = ')';
                    break;
            }

            if (!$flags['nosimbol']) {
                $currency = $cprefix .
                    ($conversion == 'i' ? $locale['int_curr_symbol'] : $locale['currency_symbol']) .
                    $csuffix;
            } else {
                $currency = $cprefix . $csuffix;
            }

            $space = $locale["{$letter}_sep_by_space"] ? ' ' : '';

            $value = number_format($value, $right, $locale['mon_decimal_point'],
                $flags['nogroup'] ? '' : $locale['mon_thousands_sep']);
            $value = @explode($locale['mon_decimal_point'], $value);

            $n = strlen($prefix) + strlen($currency) + strlen($value[0]);

            if ($left > 0 && $left > $n) {
                $value[0] = str_repeat($flags['fillchar'], $left - $n) . $value[0];
            }

            $value = implode($locale['mon_decimal_point'], $value);

            if ($locale["{$letter}_cs_precedes"]) {
                $value = $prefix . $currency . $space . $value . $suffix;
            } else {
                $value = $prefix . $value . $space . $currency . $suffix;
            }

            if ($width > 0) {
                $value = str_pad($value, $width, $flags['fillchar'], $flags['isleft'] ?
                    STR_PAD_RIGHT : STR_PAD_LEFT);
            }

            $format = str_replace($fmatch[0], $value, $format);
        }

        return $format;
    }
}

if (! function_exists('moneyFormat')) {

    /**
     * moneyFormat function.
     *
     * @access public
     * @param mixed $number
     * @return string
     */
    function moneyFormat($number)
    {
        if (!$number) {
            return '$0.00';
        }

        setlocale(LC_MONETARY, 'en_US.UTF-8');

        return money_format('%.2n', $number);
    }
}

if (! function_exists('dateRange')) {

    /**
     * dateRange function.
     *
     * @access public
     * @param mixed $first
     * @param mixed $last
     * @param string $format (default: 'm/d/Y')
     * @return void
     */
    function dateRange($first, $last, $format = 'm/d/Y')
    {
        $dates = [];

        $first = Carbon::parse($first);
        $last = Carbon::parse($last);

        for ($date = $first; $date->lte($last); $date->addDay()) {
            $dates[] = $date->format($format);
        }

        return $dates;
    }
}
if (! function_exists('DateInRange')) {

    /**
     * DateInRange function.
     *
     * @access public
     * @param mixed $startDate
     * @param mixed $endDate
     * @param mixed $date
     * @return void
     */
    function DateInRange($startDate, $endDate, $date)
    {
        $start_ts = strtotime($startDate);
        $end_ts = strtotime($endDate);
        $user_ts = strtotime($date);

        return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));
    }
}

if (! function_exists('getRandomColor')) {
    /**
     * getRandomColor function.
     *
     * @access public
     * @return string
     */
    function getRandomColor()
    {
        $randomcolor = '#' . strtoupper(dechex(rand(0, 10000000)));

        if (strlen($randomcolor) != 7) {
            $randomcolor = str_pad($randomcolor, 10, '0', STR_PAD_RIGHT);
            $randomcolor = substr($randomcolor, 0, 7);
        }

        return $randomcolor;
    }
}

if (! function_exists('base64UrlEncode')) {
    /**
     * @param $input
     * @return string
     */
    function base64UrlEncode($input)
    {
        return strtr(base64_encode($input), '+/=', '-_,');
    }
}

if (! function_exists('base64UrlDecode')) {
    /**
     * @param $input
     * @return string
     */
    function base64UrlDecode($input)
    {
        return base64_decode(strtr($input, '-_,', '+/='));
    }
}

if (! function_exists('unSlug')) {
    /**
     * Unslugs given string eg from "foo-bar" to "Foo Bar"
     *
     * @param $text
     * @return mixed
     */
    function unSlug($text)
    {
        return ucwords(str_replace(['-', '_'], [' ', ' '], $text));
    }
}

if (! function_exists('getSql')) {
    /**
     * getSql function.
     *
     * @access public
     * @param mixed $builder
     * @return void
     */
    function getSql($builder)
    {
        $addSlashes = str_replace('?', "'?'", $builder->toSql());

        return vsprintf(str_replace('?', '%s', $addSlashes), $builder->getBindings());
    }
}
