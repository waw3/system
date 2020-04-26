<?php

namespace Modules\Plugins\Product\Repositories\Interfaces;

use Modules\Support\Repositories\Interfaces\RepositoryInterface;
use Eloquent;

interface ProductInterface extends RepositoryInterface
{
    /**
     * @param int $limit
     * @return mixed
     */
    public function getFeatured($limit = 5);

    /**
     * @param array $filters
     * @return mixed
     */
    public function getFilters(array $filters);

    /**
     * @param array $selected
     * @param int $limit
     * @return mixed
     */
    public function getListProductNonInList(array $selected = [], $limit = 7);

    /**
     * @param int|array $categoryId
     * @param int $paginate
     * @param int $limit
     * @return mixed
     */
    public function getByProCategory($procategoryId, $paginate = 12, $limit = 0);

    /**
     * @param int $authorId
     * @param int $limit
     * @return mixed
     */
    public function getByUserId($authorId, $limit = 6);

    /**
     * @return mixed
     */
    public function getDataSiteMap();

    /**
     * @param int $tag
     * @param int $paginate
     * @return mixed
     */
    public function getByProTag($tag, $paginate = 12);

    /**
     * @param int $id
     * @param int $limit
     * @return mixed
     */
    public function getRelated($id, $limit = 3);

    /**
     * @param int $limit
     * @param int $categoryId
     * @return mixed
     */
    public function getRecentProducts($limit = 5, $procategoryId = 0);

    /**
     * @param string $query
     * @param int $limit
     * @param int $paginate
     * @return mixed
     */
    public function getSearchPro($query, $limit = 10, $paginate = 10);

    /**
     * @param int $perPage
     * @param bool $active
     * @return mixed
     */
    public function getAllProducts($perPage = 12, $active = true);

    /**
     * @param int $limit
     * @param array $args
     * @return mixed
     */
    public function getPopularProducts($limit, array $args = []);

    /**
     * @param Eloquent|int $model
     * @return array
     */
    public function getRelatedProCategoryIds($model);
}
