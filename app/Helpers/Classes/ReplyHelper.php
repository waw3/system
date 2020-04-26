<?php namespace App\Helpers\Classes;

use Illuminate\Contracts\Validation\Validator;

/**
 * ReplyHelper class.
 */
class ReplyHelper
{

    /** Return success response
     * @param $message
     * @return array
     */
    public static function success($message)
    {
        return [
            "status" => "success",
            "message" => self::getTranslated($message)
        ];
    }

    /**
     * successWithData function.
     *
     * @access public
     * @static
     * @param mixed $message
     * @param mixed $data
     * @return void
     */
    public static function successWithData($message, $data)
    {
        $response = self::success($message);

        return array_merge($response, $data);
    }

    /** Return error response
     * @param $message
     * @return array
     */
    public static function error($message, $error_name = null, $errorData = [])
    {
        return [
            "status" => "fail",
            "error_name" => $error_name,
            "data" => $errorData,
            "message" => self::getTranslated($message)
        ];
    }

    /** Return validation errors
     * @param \Illuminate\Validation\Validator|Validator $validator
     * @return array
     */
    public static function formErrors($validator)
    {
        return [
            "status" => "fail",
            "errors" => $validator->getMessageBag()->toArray()
        ];
    }

    /** Response with redirect action. This is meant for ajax responses and is not meant for direct redirecting
     * to the page
     * @param $url string to redirect to
     * @param null $message Optional message
     * @return array
     */
    public static function redirect($url, $message = null)
    {
        if ($message) {
            return [
                "status" => "success",
                "message" => self::getTranslated($message),
                "action" => "redirect",
                "url" => $url
            ];
        } else {
            return [
                "status" => "success",
                "action" => "redirect",
                "url" => $url
            ];
        }
    }

    /**
     * getTranslated function.
     *
     * @access private
     * @static
     * @param mixed $message
     * @return void
     */
    private static function getTranslated($message)
    {
        $trans = trans($message);

        if ($trans == $message) {
            return $message;
        } else {
            return $trans;
        }
    }

    /**
     * dataOnly function.
     *
     * @access public
     * @static
     * @param mixed $data
     * @return void
     */
    public static function dataOnly($data)
    {
        return $data;
    }
}
