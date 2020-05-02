<?php

namespace Modules\CustomField\Repositories\Caches;

use Modules\CustomField\Repositories\Interfaces\FieldItemInterface;
use Modules\Support\Repositories\Caches\CacheAbstractDecorator;

class FieldItemCacheDecorator extends CacheAbstractDecorator implements FieldItemInterface
{
    /**
     * {@inheritdoc}
     */
    public function deleteFieldItem($id)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function getGroupItems($groupId, $parentId = null)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function updateWithUniqueSlug($id, array $data)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }
}
