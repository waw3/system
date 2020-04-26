<?php

namespace Modules\Plugins\Vendor\Repositories\Caches;

use Modules\Plugins\Vendor\Repositories\Interfaces\VendorActivityLogInterface;
use Modules\Support\Repositories\Caches\CacheAbstractDecorator;

class VendorActivityLogCacheDecorator extends CacheAbstractDecorator implements VendorActivityLogInterface
{
    /**
     * {@inheritdoc}
     */
    public function getAllLogs($vendorId, $paginate = 10)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
