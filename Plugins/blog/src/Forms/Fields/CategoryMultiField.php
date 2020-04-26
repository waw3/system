<?php

namespace Modules\Plugins\Blog\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;

class CategoryMultiField extends FormField
{

    /**
     * @return string
     */
    protected function getTemplate()
    {
        return 'modules.plugins.blog::categories.categories-multi';
    }
}
