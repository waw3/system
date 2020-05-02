<?php

namespace Modules\CustomField\Repositories\Caches;

use Modules\CustomField\Repositories\Interfaces\FieldGroupInterface;
use Modules\Support\Repositories\Caches\CacheAbstractDecorator;

class FieldGroupCacheDecorator extends CacheAbstractDecorator implements FieldGroupInterface
{
    /**
     * {@inheritdoc}
     */
    public function getFieldGroups(array $condition = [])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function createFieldGroup(array $data)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function createOrUpdateFieldGroup($id, array $data)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function updateFieldGroup($id, array $data)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function getFieldGroupItems(
        $groupId,
        $parentId = null,
        $withValue = false,
        $morphClass = null,
        $morphId = null
    ) {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
