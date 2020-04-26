<?php

if (! function_exists('getDefinedUserFunctions')) {

    /**
     * getDefinedUserFunctions function.
     *
     * @access public
     * @return void
     */
    function getDefinedUserFunctions()
    {
        $defined_functions = get_defined_functions();

        $functions = [];
        foreach($defined_functions['user'] as $user_function){
            $reflFunc = new \ReflectionFunction($user_function);
/*             print $reflFunc->getFileName() . ':' . $reflFunc->getStartLine(); */

            $fun = [
                'path' => $reflFunc->getFileName(),
                'line' => $reflFunc->getStartLine()
            ];

            $functions[$user_function] = $fun;
        }


        dd($functions);
    }
}

if (! function_exists('prettyPrint')) {
    /**
     * prints array in readable format
     *
     * @param $data
     * @param bool $exit
     */
    function prettyPrint($data, $exit = true)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';

        if ($exit) {
            exit;
        }

    }
}



if (!function_exists('d')) {
    function d()
    {
        $args = func_get_args();
        call_user_func_array('dump', $args);
    }
}



if (! function_exists('count_recursive')) {
  /**
   * count_recursive function.
   *
   * @access public
   * @param mixed $array
   * @return void
   */
  function count_recursive($array)
  {
      $i = 0;
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $data) {
                    $i++;
                }
            }
        }

      return $i;
  }
}

  // Convert text representations for boolean to actual boolean values
  if (! function_exists('toBool')) {

    /**
     * toBool function.
     *
     * @access public
     * @param mixed $string
     * @return void
     */
    function toBool($string)
    {
        $string = strtolower($string);
        $value = 0;
        if ($string === 'true') {
            $value = 1;
        }
        if ($string === 'false') {
            $value = 0;
        }

        return boolval($value);
    }
}




if (!function_exists('checkDatabaseConnection')) {

    /**
     * @return bool
     */
    function checkDatabaseConnection()
    {
        try {
            DB::connection()->reconnect();

            return true;
        } catch (Exception $ex) {
            return false;
        }
    }
}
