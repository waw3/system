<?php

namespace Modules\Plugins\Gallery\Repositories\Caches;

use Modules\Support\Repositories\Caches\CacheAbstractDecorator;
use Modules\Plugins\Gallery\Repositories\Interfaces\GalleryInterface;

class GalleryCacheDecorator extends CacheAbstractDecorator implements GalleryInterface
{
    /**
     * {@inheritdoc}
     */
    public function getAll()
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

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
    public function getFeaturedGalleries($limit)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
