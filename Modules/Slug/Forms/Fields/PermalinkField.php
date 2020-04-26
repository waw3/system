<?php

namespace Modules\Slug\Forms\Fields;

use Assets;
use Kris\LaravelFormBuilder\Fields\FormField;

class PermalinkField extends FormField
{

    /**
     * @return string
     */
    protected function getTemplate()
    {
        Assets::addScriptsDirectly('vendor/core/packages/slug/js/slug.js');

        return 'modules.slug::forms.fields.permalink';
    }
}
