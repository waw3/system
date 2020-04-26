<?php

namespace Modules\Dashboard\Repositories\Caches;

use Modules\Dashboard\Repositories\Interfaces\DashboardWidgetSettingInterface;
use Modules\Support\Repositories\Caches\CacheAbstractDecorator;

class DashboardWidgetSettingCacheDecorator extends CacheAbstractDecorator implements DashboardWidgetSettingInterface
{
    /**
     * {@inheritdoc}
     */
    public function getListWidget()
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
