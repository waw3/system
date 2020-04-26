<?php

namespace Modules\Plugins\Product\Repositories\Eloquent;

use Modules\Base\Enums\BaseStatusEnum;
use Modules\Support\Repositories\Eloquent\RepositoriesAbstract;
use Modules\Plugins\Product\Repositories\Interfaces\ProductInterface;
use Eloquent;
use Exception;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Arr;

class ProductRepository extends RepositoriesAbstract implements ProductInterface
{
    /**
     * {@inheritdoc}
     */
    public function getFeatured($limit = 5)
    {
        $data = $this->model
            ->where([
                'products.status'      => BaseStatusEnum::PUBLISHED,
                'products.is_featured' => 1,
            ])
            ->limit($limit)
            ->with('slugable')
            ->orderBy('products.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getListProductNonInList(array $selected = [], $limit = 7)
    {
        $data = $this->model
            ->where('products.status', BaseStatusEnum::PUBLISHED)
            ->whereNotIn('products.id', $selected)
            ->limit($limit)
            ->with('slugable')
            ->orderBy('products.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getRelated($id, $limit = 3)
    {
        $data = $this->model
            ->where('products.status', BaseStatusEnum::PUBLISHED)
            ->where('products.id', '!=', $id)
            ->limit($limit)
            ->with('slugable')
            ->orderBy('products.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getByProCategory($procategoryId, $paginate = 12, $limit = 0)
    {
        if (!is_array($procategoryId)) {
            $procategoryId = [$procategoryId];
        }

        $data = $this->model
            ->where('products.status', BaseStatusEnum::PUBLISHED)
            ->join('product_categories', 'product_categories.product_id', '=', 'products.id')
            ->join('procategories', 'product_categories.pro_category_id', '=', 'procategories.id')
            ->whereIn('product_categories.pro_category_id', $procategoryId)
            ->select('products.*')
            ->distinct()
            ->with('slugable')
            ->orderBy('products.created_at', 'desc');

        if ($paginate != 0) {
            return $this->applyBeforeExecuteQuery($data)->paginate($paginate);
        }

        return $this->applyBeforeExecuteQuery($data)->limit($limit)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getByUserId($authorId, $paginate = 6)
    {
        $data = $this->model
            ->where([
                'products.status'    => BaseStatusEnum::PUBLISHED,
                'products.author_id' => $authorId,
            ])
            ->with('slugable')
            ->select('products.*')
            ->orderBy('products.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->paginate($paginate);
    }

    /**
     * {@inheritdoc}
     */
    public function getDataSiteMap()
    {
        $data = $this->model
            ->with('slugable')
            ->where('products.status', BaseStatusEnum::PUBLISHED)
            ->select('products.*')
            ->orderBy('products.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getByProTag($protag, $paginate = 12)
    {
        $data = $this->model
            ->with('slugable')
            ->where('products.status', BaseStatusEnum::PUBLISHED)
            ->whereHas('protags', function ($query) use ($protag) {
                /**
                 * @var Builder $query
                 */
                $query->where('protags.id', $tag);
            })
            ->select('products.*')
            ->orderBy('products.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->paginate($paginate);
    }

    /**
     * {@inheritdoc}
     */
    public function getRecentProducts($limit = 5, $procategoryId = 0)
    {
        $products = $this->model->where(['products.status' => BaseStatusEnum::PUBLISHED]);

        if ($procategoryId != 0) {
            $products = $products->join('product_categories', 'product_categories.product_id', '=', 'products.id')
                ->where('product_categories.pro_category_id', $procategoryId);
        }

        $data = $products->limit($limit)
            ->with('slugable')
            ->select('products.*')
            ->orderBy('products.created_at', 'desc');

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getSearchPro($query, $limit = 10, $paginate = 10)
    {
        $products = $this->model->with('slugable')->where('status', BaseStatusEnum::PUBLISHED);
        foreach (explode(' ', $query) as $term) {
            $products = $products->where('name', 'LIKE', '%' . $term . '%');
        }

        $data = $products->select('products.*')
            ->orderBy('products.created_at', 'desc');

        if ($limit) {
            $data = $data->limit($limit);
        }

        if ($paginate) {
            return $this->applyBeforeExecuteQuery($data)->paginate($paginate);
        }

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getAllProducts($perPage = 12, $active = true)
    {
        $data = $this->model->select('products.*')
            ->with('slugable')
            ->orderBy('products.created_at', 'desc');

        if ($active) {
            $data = $data->where('products.status', BaseStatusEnum::PUBLISHED);
        }

        return $this->applyBeforeExecuteQuery($data)->paginate($perPage);
    }

    /**
     * {@inheritdoc}
     */
    public function getPopularProducts($limit, array $args = [])
    {
        $data = $this->model
            ->with('slugable')
            ->orderBy('products.views', 'desc')
            ->select('products.*')
            ->where('products.status', BaseStatusEnum::PUBLISHED)
            ->limit($limit);

        if (!empty(Arr::get($args, 'where'))) {
            $data = $data->where($args['where']);
        }

        return $this->applyBeforeExecuteQuery($data)->get();
    }

    /**
     * {@inheritdoc}
     */
    public function getRelatedProCategoryIds($model)
    {
        $model = $model instanceof Eloquent ? $model : $this->findOrFail($model);

        try {
            return $model->procategories()->allRelatedIds()->toArray();
        } catch (Exception $exception) {
            return [];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters(array $filters)
    {
        $this->model = $this->originalModel;

        if ($filters['procategories'] !== null) {
            $procategories = $filters['procategories'];
            $this->model = $this->model->whereHas('procategories', function ($query) use ($procategories) {
                $query->whereIn('procategories.id', $procategories);
            });
        }

        if ($filters['procategories_exclude'] !== null) {
            $procategories_exclude = $filters['procategories_exclude'];
            $this->model = $this->model->whereHas('procategories', function ($query) use ($procategories_exclude) {
                $query->whereNotIn('procategories.id', $procategories_exclude);
            });
        }

        if ($filters['exclude'] !== null) {
            $this->model = $this->model->whereNotIn('id', $filters['exclude']);
        }

        if ($filters['include'] !== null) {
            $this->model = $this->model->whereNotIn('id', $filters['include']);
        }

        if ($filters['author'] !== null) {
            $this->model = $this->model->whereIn('author_id', $filters['author']);
        }

        if ($filters['author_exclude'] !== null) {
            $this->model = $this->model->whereNotIn('author_id', $filters['author_exclude']);
        }

        if ($filters['featured'] !== null) {
            $this->model = $this->model->where('is_featured', $filters['featured']);
        }

        

        if ($filters['search'] !== null) {
            $filters_search = str_replace(' ','%',$filters['search']);
            $this->model = $this->model->where('name', 'like', '%' . $filters_search . '%')
                ->orWhere('content', 'like', '%' . $filters['search'] . '%');
        }

        $order_by = isset($filters['order_by']) ? $filters['order_by'] : 'updated_at';
        $order = isset($filters['order']) ? $filters['order'] : 'desc';
        $this->model->where('status', BaseStatusEnum::PUBLISHED)->orderBy($order_by, $order);

        return $this->applyBeforeExecuteQuery($this->model)->paginate((int)$filters['per_page']);
    }
}
