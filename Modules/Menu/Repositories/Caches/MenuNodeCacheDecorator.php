<?php

namespace Modules\Menu\Repositories\Caches;

use Modules\Menu\Repositories\Interfaces\MenuNodeInterface;
use Modules\Support\Repositories\Caches\CacheAbstractDecorator;

class MenuNodeCacheDecorator extends CacheAbstractDecorator implements MenuNodeInterface
{
    /**
     * {@inheritdoc}
     */
    public function getByMenuId($menuId, $parentId, $select = ['*'])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
