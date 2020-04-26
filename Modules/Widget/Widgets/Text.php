<?php

namespace Modules\Widget\Widgets;

use Modules\Widget\Services\AbstractWidget;
use Illuminate\Contracts\Filesystem\FileNotFoundException;

class Text extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * @var string
     */
    protected $frontendTemplate = 'modules.widget::widgets.text.frontend';

    /**
     * @var string
     */
    protected $backendTemplate = 'modules.widget::widgets.text.backend';

    /**
     * @var bool
     */
    protected $isCore = true;

    /**
     * Text constructor.
     *
     * @throws FileNotFoundException
     */
    public function __construct()
    {
        parent::__construct([
            'name'        => trans('modules.widget::global.widget_text'),
            'description' => trans('modules.widget::global.widget_text_description'),
            'content'     => null,
        ]);
    }
}
