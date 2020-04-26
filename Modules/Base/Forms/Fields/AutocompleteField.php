<?php

namespace Modules\Base\Forms\Fields;

use Kris\LaravelFormBuilder\Fields\SelectType;

class AutocompleteField extends SelectType
{

    /**
     * Get the template, can be config variable or view path.
     *
     * @return string
     */
    protected function getTemplate()
    {
        return 'modules.base::forms.fields.autocomplete';
    }
}
