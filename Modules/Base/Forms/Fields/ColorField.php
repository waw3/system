<?php

namespace Modules\Base\Forms\Fields;

use Assets;
use Kris\LaravelFormBuilder\Fields\FormField;

class ColorField extends FormField
{

    /**
     * Get the template, can be config variable or view path.
     *
     * @return string
     */
    protected function getTemplate()
    {
        Assets::addScripts(['colorpicker'])
            ->addStyles(['colorpicker']);

        return 'modules.base::forms.fields.color';
    }
}