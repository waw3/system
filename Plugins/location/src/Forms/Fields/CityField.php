<?php

namespace Modules\Plugins\Location\Forms\Fields;

use Assets;
use Kris\LaravelFormBuilder\Fields\SelectType;

class CityField extends SelectType
{

    /**
     * The name of the property that holds the value.
     *
     * @var string
     */
    protected $valueProperty = 'selected';

    /**
     * @return string
     */
    protected function getTemplate()
    {
        Assets::addScriptsDirectly(['vendor/core/plugins/location/js/location.js']);

        return 'modules.plugins.location::forms.city-field';
    }
}
