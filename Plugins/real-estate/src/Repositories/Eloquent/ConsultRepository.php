<?php

namespace Modules\Plugins\RealEstate\Repositories\Eloquent;

use Modules\Plugins\RealEstate\Enums\ConsultStatusEnum;
use Modules\Support\Repositories\Eloquent\RepositoriesAbstract;
use Modules\Plugins\RealEstate\Repositories\Interfaces\ConsultInterface;

class ConsultRepository extends RepositoriesAbstract implements ConsultInterface
{
    /**
     * {@inheritdoc}
     */
    public function getUnread($select = ['*'])
    {
        $data = $this->model->where('status', ConsultStatusEnum::UNREAD)->select($select)->get();
        $this->resetModel();

        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function countUnread()
    {
        $data = $this->model->where('status', ConsultStatusEnum::UNREAD)->count();
        $this->resetModel();

        return $data;
    }
}
