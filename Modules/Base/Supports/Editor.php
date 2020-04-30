<?php

namespace Modules\Base\Supports;

use Assets, Throwable;
use Illuminate\Support\Arr;

/**
 * Editor class.
 */
class Editor
{

    /**
     * __construct function.
     *
     * @access public
     * @return void
     */
    public function __construct()
    {
        add_action('base_action_enqueue_scripts', [$this, 'registerAssets'], 12, 1);
    }

    /**
     * registerAssets function.
     *
     * @access public
     * @return void
     */
    public function registerAssets()
    {
        $rich_editor = setting('rich_editor', mconfig('base.config.editor.primary'));
        $scriptFilePath = mconfig('base.config.editor.' . $rich_editor . '.js');

        Assets::addScriptsDirectly($scriptFilePath)->addScriptsDirectly('vendor/core/js/editor.js');
    }

    /**
     * @param $name
     * @param null $value
     * @param bool $withShortCode
     * @param array $attributes
     * @return string
     * @throws Throwable
     */
    public function render($name, $value = null, $withShortCode = false, array $attributes = [])
    {
        $attributes['class'] = Arr::get($attributes, 'class', '') . ' editor-' . setting('rich_editor', mconfig('base.config.editor.primary'));
        $attributes['id'] = Arr::has($attributes, 'id') ? $attributes['id'] : $name;
        $attributes['with-short-code'] = $withShortCode;
        $attributes['rows'] = Arr::get($attributes, 'rows', 4);

        return view('modules.base::elements.forms.editor', compact('name', 'value', 'attributes'))->render();
    }
}
