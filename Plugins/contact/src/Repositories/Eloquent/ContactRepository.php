<?php

namespace Modules\Plugins\Contact\Repositories\Eloquent;

use Modules\Plugins\Contact\Enums\ContactStatusEnum;
use Modules\Plugins\Contact\Repositories\Interfaces\ContactInterface;
use Modules\Support\Repositories\Eloquent\RepositoriesAbstract;

class ContactRepository extends RepositoriesAbstract implements ContactInterface
{
    /**
     * {@inheritdoc}
     */
    public function getUnread($select = ['*'])
    {
        $data = $this->model->where('status', ContactStatusEnum::UNREAD)->select($select)->get();
        $this->resetModel();
        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function countUnread()
    {
        $data = $this->model->where('status', ContactStatusEnum::UNREAD)->count();
        $this->resetModel();
        return $data;
    }
}
