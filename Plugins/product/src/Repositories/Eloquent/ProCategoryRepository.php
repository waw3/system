<?php

namespace Modules\Plugins\Product\Repositories\Eloquent;

use Modules\Base\Enums\BaseStatusEnum;
use Modules\Support\Repositories\Eloquent\RepositoriesAbstract;
use Modules\Plugins\Product\Repositories\Interfaces\ProCategoryInterface;
use Eloquent;

class ProCategoryRepository extends RepositoriesAbstract implements ProCategoryInterface
{

    /**
     * {@inheritdoc}
     */
    public function getDataSiteMap()
    {
        $data = $this->model
            ->with('slugable')
            ->where('procategories.status', BaseStatusEnum::PUBLISHED)
            ->select('procategories.*')
            ->orderBy('procategories.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getFeaturedProCategories($limit)
    {
        $data = $this->model
            ->with('slugable')
            ->where([
                'procategories.status'      => BaseStatusEnum::PUBLISHED,
                'procategories.is_featured' => 1,
            ])
            ->select([
                'procategories.id',
                'procategories.name',
                'procategories.icon',
            ])
            ->orderBy('procategories.order', 'asc')
            ->select('procategories.*')
            ->limit($limit);

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getAllProCategories(array $condition = [])
    {
        $data = $this->model->with('slugable')->select('procategories.*');
        if (!empty($condition)) {
            $data = $data->where($condition);
        }

        $data = $data->orderBy('procategories.order', 'DESC');

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getProCategoryById($id)
    {
        $data = $this->model->with('slugable')->where([
            'procategories.id'     => $id,
            'procategories.status' => BaseStatusEnum::PUBLISHED,
        ]);

        return $this->applyBeforeExecuteQuery($data, true)->first();
    }

    /**
     * {@inheritdoc}
     */
    public function getProCategories(array $select, array $orderBy)
    {
        $data = $this->model->with('slugable')->select($select);
        foreach ($orderBy as $by => $direction) {
            $data = $data->orderBy($by, $direction);
        }

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getAllRelatedChildrenIds($id)
    {
        if ($id instanceof Eloquent) {
            $model = $id;
        } else {
            $model = $this->getFirstBy(['procategories.id' => $id]);
        }
        if (!$model) {
            return null;
        }

        $result = [];

        $children = $model->children()->select('procategories.id')->get();

        foreach ($children as $child) {
            $result[] = $child->id;
            $result = array_merge($this->getAllRelatedChildrenIds($child), $result);
        }
        $this->resetModel();

        return array_unique($result);
    }

    /**
     * {@inheritdoc}
     */
    public function getAllProCategoriesWithChildren(array $condition = [], array $with = [], array $select = ['*'])
    {
        $data = $this->model
            ->where($condition)
            ->with($with)
            ->select($select);

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters($filters)
    {
        $this->model = $this->originalModel;

        $orderBy = isset($filters['order_by']) ? $filters['order_by'] : 'created_at';
        $order = isset($filters['order']) ? $filters['order'] : 'desc';
        $this->model->where('status', BaseStatusEnum::PUBLISHED)->orderBy($orderBy, $order);

        return $this->applyBeforeExecuteQuery($this->model)->paginate((int)$filters['per_page']);
    }
}
