<?php

namespace Modules\Block\Repositories\Caches;

use Modules\Support\Repositories\Caches\CacheAbstractDecorator;
use Modules\Block\Repositories\Interfaces\BlockInterface;

class BlockCacheDecorator extends CacheAbstractDecorator implements BlockInterface
{
    /**
     * {@inheritdoc}
     */
    public function createSlug($name, $id)
    {
        return $this->flushCacheAndUpdateData(__FUNCTION__, func_get_args());
    }
}
