<?php

use Modules\Widget\Services\AbstractWidget;

class PopularPostsWidget extends AbstractWidget
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
    protected $frontendTemplate = 'frontend';

    /**
     * @var string
     */
    protected $backendTemplate = 'backend';

    /**
     * @var string
     */
    protected $widgetDirectory = 'popular-posts';

    /**
     * PopularPostsWidget constructor.
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function __construct()
    {
        parent::__construct([
            'name'           => 'Popular Posts - LaraMag Theme',
            'description'    => 'Show list popular posts',
            'number_display' => 5,
        ]);
    }
}