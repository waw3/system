<?php

namespace Modules\Base\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\FormField;

class CustomRadioField extends FormField
{

    /**
     * @return string
     */
    protected function getTemplate()
    {
        return 'modules.base::forms.fields.custom-radio';
    }
}