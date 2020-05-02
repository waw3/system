<?php

namespace Modules\Blog\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;

class CategoryMultiField extends FormField
{

    /**
     * @return string
     */
    protected function getTemplate()
    {
        return 'modules.blog::categories.categories-multi';
    }
}
