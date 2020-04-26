<?php

namespace Modules\Plugins\Product\Repositories\Caches;

use Modules\Support\Repositories\Caches\CacheAbstractDecorator;
use Modules\Plugins\Product\Repositories\Interfaces\ProCategoryInterface;

class ProCategoryCacheDecorator extends CacheAbstractDecorator implements ProCategoryInterface
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
    public function getFeaturedProCategories($limit)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function getAllProCategories(array $condition = [])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function getProCategoryById($id)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function getProCategories(array $select, array $orderBy)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function getAllRelatedChildrenIds($id)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    
    public function getAllProCategoriesWithChildren(array $condition = [], array $with = [], array $select = ['*'])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters($model)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
