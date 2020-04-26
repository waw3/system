<?php

namespace Modules\Plugins\Product\Repositories\Eloquent;

use Modules\Base\Enums\BaseStatusEnum;
use Modules\Support\Repositories\Eloquent\RepositoriesAbstract;
use Modules\Plugins\Product\Repositories\Interfaces\ProTagInterface;

class ProTagRepository extends RepositoriesAbstract implements ProTagInterface
{

    /**
     * {@inheritdoc}
     */
    public function getDataSiteMap()
    {
        $data = $this->model
            ->with('slugable')
            ->where('protags.status', '=', BaseStatusEnum::PUBLISHED)
            ->select('protags.*')
            ->orderBy('protags.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getPopularProTags($limit)
    {
        $data = $this->model
            ->with('slugable')
            ->orderBy('protags.id', 'DESC')
            ->select('protags.*')
            ->limit($limit);

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getAllProTags($active = true)
    {
        $data = $this->model->select('protags.*');
        if ($active) {
            $data = $data->where(['protags.status' => BaseStatusEnum::PUBLISHED]);
        }

        return $this->applyBeforeExecuteQuery($data)->get();
    }
}
