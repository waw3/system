<?php

namespace Modules\Widget\Repositories\Caches;

use Modules\Support\Repositories\Caches\CacheAbstractDecorator;
use Modules\Widget\Repositories\Interfaces\WidgetInterface;

class WidgetCacheDecorator extends CacheAbstractDecorator implements WidgetInterface
{
    /**
     * {@inheritdoc}
     */
    public function getByTheme($theme)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
