<?php

namespace Modules\Plugins\Location\Forms\Fields;

use Assets;
use Kris\LaravelFormBuilder\Fields\SelectType;

class StateField extends SelectType
{

    /**
     * @return string
     */
    protected function getTemplate()
    {
        Assets::addScriptsDirectly(['vendor/core/plugins/location/js/location.js']);

        return 'modules.plugins.location::forms.state-field';
    }
}
