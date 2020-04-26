<?php

namespace Modules\Plugins\Product\Repositories\Caches;

use Modules\Support\Repositories\Caches\CacheAbstractDecorator;
use Modules\Plugins\Product\Repositories\Interfaces\ProTagInterface;

class ProTagCacheDecorator extends CacheAbstractDecorator implements ProTagInterface
{
    /**
     * {@inheritdoc}
     */
    public function getDataSiteMap()
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function getPopularProTags($limit)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function getAllProTags($active = true)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
