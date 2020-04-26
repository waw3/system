<?php

namespace Modules\Plugins\Blog\Repositories\Caches;

use Modules\Support\Repositories\Caches\CacheAbstractDecorator;
use Modules\Plugins\Blog\Repositories\Interfaces\TagInterface;

class TagCacheDecorator extends CacheAbstractDecorator implements TagInterface
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
    public function getPopularTags($limit)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function getAllTags($active = true)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
