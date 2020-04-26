<?php

namespace Modules\Plugins\RealEstate\Repositories\Interfaces;

use Modules\Support\Repositories\Interfaces\RepositoryInterface;

interface ConsultInterface extends RepositoryInterface
{
    /**
     * @param array $select
     * @return mixed
     */
    public function getUnread($select = ['*']);

    /**
     * @return int
     */
    public function countUnread();
}
