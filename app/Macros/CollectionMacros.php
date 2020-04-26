<?php
return [

    /**
     * toAssoc function.
     *
     * @access public
     * @return void
     */
    'toAssoc' => function () {
        return $this->reduce(function ($assoc, $keyValuePair) {
            list($key, $value) = $keyValuePair;
            $assoc[$key] = $value;

            return $assoc;
        }, new static);
    },

    /**
     * mapToAssoc function.
     *
     * @access public
     * @param mixed $callback
     * @return void
     */
    'mapToAssoc' => function ($callback) {
        return $this->map($callback)->toAssoc();
    },

];
