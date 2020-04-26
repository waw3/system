<?php

namespace Modules\Plugins\Member\Repositories\Eloquent;

use Modules\Plugins\Member\Repositories\Interfaces\MemberActivityLogInterface;
use Modules\Support\Repositories\Eloquent\RepositoriesAbstract;

class MemberActivityLogRepository extends RepositoriesAbstract implements MemberActivityLogInterface
{
    /**
     * {@inheritdoc}
     */
    public function getAllLogs($memberId, $paginate = 10)
    {
        return $this->model
            ->where('member_id', $memberId)
            ->latest('created_at')
            ->paginate($paginate);
    }
}
