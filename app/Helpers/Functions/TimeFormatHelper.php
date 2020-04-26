<?php

use Carbon\Carbon;

if (! function_exists('today')) {

    /**
     * today function.
     *
     * @access public
     * @param mixed $format (default: null)
     * @return void
     */
    function today($format=null)
    {
    	$format = $format ? $format:'Y-m-d H:i:s';
    	return Carbon::today()->format($format);
    }
}

if (! function_exists('today'))
{

    /**
     * tomorrow function.
     *
     * @access public
     * @param mixed $format (default: null)
     * @return void
     */
    function tomorrow($format=null)
    {
    	$format = $format ? $format:'Y-m-d H:i:s';
    	return Carbon::tomorrow()->format($format);
    }
}

if (! function_exists('yesterday'))
{

    /**
     * yesterday function.
     *
     * @access public
     * @param mixed $format (default: null)
     * @return void
     */
    function yesterday($format=null)
    {
    	$format = $format ? $format:'Y-m-d H:i:s';
    	return Carbon::yesterday()->format($format);
    }
}

if (! function_exists('nextDay'))
{

    /**
     * nextDay function.
     *
     * @access public
     * @param mixed $datetime (default: null)
     * @param mixed $day
     * @param mixed $format (default: null)
     * @return void
     */
    function nextDay($datetime=null, $day, $format=null)
    {
    	$day = strtoupper($day);
    	$format = $format ? $format:'Y-m-d H:i:s';
    	$datetime = $datetime ? $datetime:Carbon::now();
    	$days = ['SUNDAY' => Carbon::SUNDAY, 'MONDAY' => Carbon::MONDAY, 'TUESDAY' => Carbon::TUESDAY, 'WEDNESDAY' => Carbon::WEDNESDAY, 'THURSDAY' => Carbon::THURSDAY, 'FRIDAY' => Carbon::FRIDAY, 'SATURDAY' => Carbon::SATURDAY];
    	return Carbon::createFromFormat('Y-m-d H:i:s', $datetime)->next($days[$day])->format($format);
    }
}

if (! function_exists('dayOfWeek'))
{

    /**
     * dayOfWeek function.
     *
     * @access public
     * @param mixed $datetime (default: null)
     * @return void
     */
    function dayOfWeek($datetime=null)
    {
    	$days = ['Sunday','Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    	$datetime = $datetime ? $datetime:Carbon::now();
    	return $days[Carbon::createFromFormat('Y-m-d H:i:s', $datetime)->dayOfWeek];
    }
}

if (! function_exists('ukDate'))
{

    /**
     * ukDate function.
     *
     * @access public
     * @param mixed $datetime (default: null)
     * @param bool $timestamp (default: false)
     * @return void
     */
    function ukDate($datetime=null, $timestamp=false)
    {
    	$datetime = $datetime ? $datetime:Carbon::now();
    	$timestamp = $timestamp ? 'd/m/Y H:ia':'d/m/Y';
    	return Carbon::createFromFormat('Y-m-d H:i:s', $datetime)->format($timestamp);
    }
}

if (! function_exists('ukDateToDate'))
{

    /**
     * ukDateToDate function.
     *
     * @access public
     * @param mixed $datetime (default: null)
     * @param bool $timestamp (default: false)
     * @return void
     */
    function ukDateToDate($datetime=null, $timestamp=false)
    {
    	$datetime = $datetime ? $datetime:Carbon::now();
    	$format = $timestamp ? 'd/m/Y H:i:s':'d/m/Y';
    	$timestamp = $timestamp ? 'Y-m-d H:i:s':'Y-m-d';
    	return Carbon::createFromFormat($format, $datetime)->format($timestamp);
    }
}

if (! function_exists('humanDate')) {
    function humanDate($datetime)
    {
    	return Carbon::createFromFormat('Y-m-d H:i:s', $datetime)->diffForHumans();
    }
}

if (! function_exists('age')) {
    function age($datetime)
    {
    	return Carbon::createFromFormat('Y-m-d', $datetime)->age;
    }
}

if (! function_exists('weekend')) {
    function weekend($datetime=null)
    {
    	$datetime = $datetime ? $datetime:Carbon::now();
    	return Carbon::createFromFormat('Y-m-d H:i:s', $datetime)->isWeekend();
    }
}

if (! function_exists('diffInDays')) {
    function diffInDays($datetime)
    {
    	return Carbon::createFromFormat('Y-m-d H:i:s', $datetime)->diffInDays();
    }
}

if (! function_exists('addYears')) {
    function addYears($datetime=null, $years, $format=null)
    {
    	$format = $format ? $format:'Y-m-d H:i:s';
    	$datetime = $datetime ? $datetime:Carbon::now();
    	return Carbon::createFromFormat('Y-m-d H:i:s', $datetime)->addYears($years)->format($format);
    }
}

if (! function_exists('addMonths')) {
    function addMonths($datetime=null, $months, $format=null)
    {
    	$format = $format ? $format:'Y-m-d H:i:s';
    	$datetime = $datetime ? $datetime:Carbon::now();
    	return Carbon::createFromFormat('Y-m-d H:i:s', $datetime)->addMonths($months)->format($format);
    }
}

if (! function_exists('addWeeks')) {
    function addWeeks($datetime=null, $weeks, $format=null)
    {
    	$format = $format ? $format:'Y-m-d H:i:s';
    	$datetime = $datetime ? $datetime:Carbon::now();
    	return Carbon::createFromFormat('Y-m-d H:i:s', $datetime)->addWeeks($weeks)->format($format);
    }
}

if (! function_exists('addDays')) {
    function addDays($datetime=null, $days, $format=null)
    {
    	$format = $format ? $format:'Y-m-d H:i:s';
    	$datetime = $datetime ? $datetime:Carbon::now();
    	return Carbon::createFromFormat('Y-m-d H:i:s', $datetime)->addDays($days)->format($format);
    }
}

if (! function_exists('startOfDay')) {
    function startOfDay($datetime=null, $format=null)
    {
    	$format = $format ? $format:'Y-m-d H:i:s';
    	$datetime = $datetime ? $datetime:Carbon::now();
    	return Carbon::createFromFormat('Y-m-d H:i:s', $datetime)->startOfDay()->format($format);
    }
}

if (! function_exists('endOfDay')) {
    function endOfDay($datetime=null, $format=null)
    {
    	$format = $format ? $format:'Y-m-d H:i:s';
    	$datetime = $datetime ? $datetime:Carbon::now();
    	return Carbon::createFromFormat('Y-m-d H:i:s', $datetime)->endOfDay()->format($format);
    }
}

if (! function_exists('startOfWeek')) {
function startOfWeek($datetime=null, $format=null)
{
	$format = $format ? $format:'Y-m-d H:i:s';
	$datetime = $datetime ? $datetime:Carbon::now();
	return Carbon::createFromFormat('Y-m-d H:i:s', $datetime)->startOfWeek()->format($format);
}
}

if (! function_exists('endOfWeek')) {
    function endOfWeek($datetime=null, $format=null)
    {
    	$format = $format ? $format:'Y-m-d H:i:s';
    	$datetime = $datetime ? $datetime:Carbon::now();
    	return Carbon::createFromFormat('Y-m-d H:i:s', $datetime)->endOfWeek()->format($format);
    }
}

if (! function_exists('startOfMonth')) {
    function startOfMonth($datetime=null, $format=null)
    {
    	$format = $format ? $format:'Y-m-d H:i:s';
    	$datetime = $datetime ? $datetime:Carbon::now();
    	return Carbon::createFromFormat('Y-m-d H:i:s', $datetime)->startOfMonth()->format($format);
    }
}

if (! function_exists('endOfMonth')) {
    function endOfMonth($datetime=null, $format=null)
    {
    	$format = $format ? $format:'Y-m-d H:i:s';
    	$datetime = $datetime ? $datetime:Carbon::now();
    	return Carbon::createFromFormat('Y-m-d H:i:s', $datetime)->endOfMonth()->format($format);
    }
}

if (! function_exists('startOfYear')) {
    function startOfYear($datetime=null, $format=null)
    {
    	$format = $format ? $format:'Y-m-d H:i:s';
    	$datetime = $datetime ? $datetime:Carbon::now();
    	return Carbon::createFromFormat('Y-m-d H:i:s', $datetime)->startOfYear()->format($format);
    }
}

if (! function_exists('endOfYear')) {
    function endOfYear($datetime=null, $format=null)
    {
    	$format = $format ? $format:'Y-m-d H:i:s';
    	$datetime = $datetime ? $datetime:Carbon::now();
    	return Carbon::createFromFormat('Y-m-d H:i:s', $datetime)->endOfYear()->format($format);
    }
}

if (! function_exists('startOfDecade')) {
    function startOfDecade($datetime=null, $format=null)
    {
    	$format = $format ? $format:'Y-m-d H:i:s';
    	$datetime = $datetime ? $datetime:Carbon::now();
    	return Carbon::createFromFormat('Y-m-d H:i:s', $datetime)->startOfDecade()->format($format);
    }
}

if (! function_exists('endOfDecade')) {
    function endOfDecade($datetime=null, $format=null)
    {
    	$format = $format ? $format:'Y-m-d H:i:s';
    	$datetime = $datetime ? $datetime:Carbon::now();
    	return Carbon::createFromFormat('Y-m-d H:i:s', $datetime)->endOfDecade()->format($format);
    }
}

if (! function_exists('startOfCentury')) {
    function startOfCentury($datetime=null, $format=null)
    {
    	$format = $format ? $format:'Y-m-d H:i:s';
    	$datetime = $datetime ? $datetime:Carbon::now();
    	return Carbon::createFromFormat('Y-m-d H:i:s', $datetime)->startOfCentury()->format($format);
    }
}

if (! function_exists('endOfCentury')) {
function endOfCentury($datetime=null, $format=null)
{
	$format = $format ? $format:'Y-m-d H:i:s';
	$datetime = $datetime ? $datetime:Carbon::now();
	return Carbon::createFromFormat('Y-m-d H:i:s', $datetime)->endOfCentury()->format($format);
}
}
