<?php

namespace Modules\Base\Providers;

use Form;
use Illuminate\Support\ServiceProvider;

class FormServiceProvider extends ServiceProvider
{

    public function boot()
    {
        Form::component('mediaImage', 'modules.base::elements.forms.image', [
            'name',
            'value'      => null,
            'attributes' => [],
        ]);

        Form::component('modalAction', 'modules.base::elements.forms.modal', [
            'name',
            'title',
            'type'        => null,
            'content'     => null,
            'action_id'   => null,
            'action_name' => null,
            'modal_size'  => null,
        ]);

        Form::component('helper', 'modules.base::elements.forms.helper', ['content']);

        Form::component('onOff', 'modules.base::elements.forms.on-off', [
            'name',
            'value'      => false,
            'attributes' => [],
        ]);

        /**
         * Custom checkbox
         * Every checkbox will not have the same name
         */
        Form::component('customCheckbox', 'modules.base::elements.custom-checkbox', [
            /**
             * @var array $values
             * @template: [
             *      [string $name, string $value, string $label, bool $selected, bool $disabled],
             *      [string $name, string $value, string $label, bool $selected, bool $disabled],
             *      [string $name, string $value, string $label, bool $selected, bool $disabled],
             * ]
             */
            'values',
        ]);

        /**
         * Custom radio
         * Every radio in list must have the same name
         */
        Form::component('customRadio', 'modules.base::elements.custom-radio', [
            /**
             * @var string $name
             */
            'name',
            /**
             * @var array $values
             * @template: [
             *      [string $value, string $label, bool $disabled],
             *      [string $value, string $label, bool $disabled],
             *      [string $value, string $label, bool $disabled],
             * ]
             */
            'values',
            /**
             * @var string|null $selected
             */
            'selected' => null,
        ]);

        Form::component('error', 'modules.base::elements.forms.error', [
            'name',
            'errors' => null,
        ]);

        Form::component('editor', 'modules.base::elements.forms.editor-input', [
            'name',
            'value'      => null,
            'attributes' => [],
        ]);

        Form::component('customSelect', 'modules.base::elements.forms.custom-select', [
            'name',
            'list'                => [],
            'selected'            => null,
            'selectAttributes'    => [],
            'optionsAttributes'   => [],
            'optgroupsAttributes' => [],
        ]);

        Form::component('googleFonts', 'modules.base::elements.forms.google-fonts', [
            'name',
            'selected'          => null,
            'selectAttributes'  => [],
            'optionsAttributes' => [],
        ]);
    }
}
