<?php

namespace Modules\Acl\Repositories\Caches;

use Modules\Acl\Repositories\Interfaces\RoleInterface;
use Modules\Support\Repositories\Caches\CacheAbstractDecorator;

class RoleCacheDecorator extends CacheAbstractDecorator implements RoleInterface
{
    /**
     * {@inheritdoc}
     */
    public function createSlug($name, $id)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }
}
