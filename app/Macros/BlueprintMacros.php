<?php

return [

    /**
     * schemalessAttributes function.
     *
     * @access public
     * @param string $columnName (default: 'schemaless_attributes')
     * @return void
     */
    'schemalessAttributes' => function (string $columnName = 'schemaless_attributes') {
        return $this->json($columnName)->nullable();
    },

    /**
     * nestedSet function.
     *
     * @access public
     * @return void
     */
    'nestedSet' => function () {
        NestedSet::columns($this);
    },

    /**
     * dropNestedSet function.
     *
     * @access public
     * @return void
     */
    'dropNestedSet' => function () {
        NestedSet::dropColumns($this);
    }

];
