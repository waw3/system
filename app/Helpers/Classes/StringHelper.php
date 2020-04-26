<?php namespace App\Helpers\Classes;


/**
 * StringHelper class.
 */
class StringHelper
{

    /**
     * @param $string
     * @param $char
     * @return bool|string
     */
    public static function fromLastChar($string, $char)
    {
        return substr(strrchr($string, $char), 1);
    }

    /**
     * validationArrayToString function.
     *
     * @access public
     * @static
     * @param mixed $array
     * @return void
     */
    public static function validationArrayToString($array)
    {
        $output = implode(', ', array_map(
            function ($v, $k) { return sprintf(" %s '%s' dependent records found. ", $k, $v); },
            $array,
            array_keys($array)
        ));
        return $output;
    }
}
