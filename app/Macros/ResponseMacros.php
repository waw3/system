<?php
return [

     /**
      * csv function.
      *
      * @access public
      * @param mixed $data
      * @param string $filename (default: 'data.csv')
      * @param int $status (default: 200)
      * @param string $delimiter (default: "|")
      * @param string $linebreak (default: "\n")
      * @param array $headers (default: array())
      * @return void
      */
    'csv' => function ($data, $filename = 'data.csv', $status = 200, $delimiter = "|", $linebreak = "\n", $headers = array()) {
        return Response::stream(function () use ($data, $delimiter, $linebreak) {
            foreach ($data as $row) {
                $keys = array();
                $values = array();
                $i = (isset($i)) ? $i+1 : 0;
                foreach ($row as $k => $v) {
                    if (!$i) {
                        $keys[] = is_string($k) ? '"' . str_replace('"', '""', $k) . '"' : $k;
                    }
                    $values[] = is_string($v) ? '"' . str_replace('"', '""', $v) . '"' : $v;
                }
                if (count($keys) > 0) {
                    echo implode($delimiter, $keys) . $linebreak;
                }
                if (count($values) > 0) {
                    echo implode($delimiter, $values) . $linebreak;
                }
            }
        }, 200, array_merge(array(
            'Content-type' => 'application/csv',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Content-Description' => 'File Transfer',
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=' . $filename,
            'Expires' => '0',
            'Pragma' => 'public',
        ), $headers));
    },

    /**
     * csv2 function.
     *
     * @access public
     * @param mixed $file
     * @param mixed $filename
     * @param int $status (default: 200)
     * @param mixed $headers (default: [])
     * @return void
     */
    'csv2' => function ($file, $filename, $status = 200, $headers = []) {
        return response($file, $status, array_merge([
                'Content-Type' => 'application/csv',
                'Content-Disposition' => "attachment; filename={$filename}",
                'Pragma' => 'no-cache',
            ], $headers));
    }
];
