<?php

use Modules\Widget\Services\AbstractWidget;

class CustomMenuWidget extends AbstractWidget
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
    protected $widgetDirectory = 'custom-menu';

    /**
     * CustomMenuWidget constructor.
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function __construct()
    {
        parent::__construct([
            'name'        => __('Custom Menu - LaraMag Theme'),
            'description' => __('Add a custom menu to your widget area.'),
            'menu_id'     => null,
        ]);
    }
}