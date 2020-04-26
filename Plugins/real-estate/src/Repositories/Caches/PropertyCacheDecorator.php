<?php

namespace Modules\Plugins\RealEstate\Repositories\Caches;

use Modules\Plugins\RealEstate\Repositories\Interfaces\PropertyInterface;
use Modules\Support\Repositories\Caches\CacheAbstractDecorator;

class PropertyCacheDecorator extends CacheAbstractDecorator implements PropertyInterface
{
    /**
     * {@inheritdoc}
     */
    public function getRelatedProperties(int $propertyId, $limit = 4)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function getProperties($filters = [], $params = [])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
