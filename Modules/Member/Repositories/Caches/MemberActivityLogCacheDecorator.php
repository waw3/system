<?php

namespace Modules\Member\Repositories\Caches;

use Modules\Member\Repositories\Interfaces\MemberActivityLogInterface;
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
