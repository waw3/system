<?php

namespace Modules\Plugins\Product\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;

class ProCategoryMultiField extends FormField
{

    /**
     * @return string
     */
    protected function getTemplate()
    {
        return 'modules.plugins.product::procategories.procategories-multi';
    }
}
