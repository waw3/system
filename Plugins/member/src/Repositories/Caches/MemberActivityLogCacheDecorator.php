<?php

namespace Modules\Plugins\Member\Repositories\Caches;

use Modules\Plugins\Member\Repositories\Interfaces\MemberActivityLogInterface;
use Modules\Support\Repositories\Caches\CacheAbstractDecorator;

class MemberActivityLogCacheDecorator extends CacheAbstractDecorator implements MemberActivityLogInterface
{
    /**
     * {@inheritdoc}
     */
    public function getAllLogs($memberId, $paginate = 10)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
