<?php

namespace Modules\Plugins\Product\Repositories\Interfaces;

use Modules\Support\Repositories\Interfaces\RepositoryInterface;
use Illuminate\Support\Collection;

interface ProCategoryInterface extends RepositoryInterface
{

    /**
     * @return array
     */
    public function getDataSiteMap();

    /**
     * @param int $limit
     */
    public function getFeaturedProCategories($limit);

    /**
     * @param array $condition
     * @return array
     */
    public function getAllProCategories(array $condition = []);

    /**
     * @param int $id
     * @return mixed
     */
    public function getProCategoryById($id);

    /**
     * @param array $select
     * @param array $orderBy
     * @return Collection
     */
    public function getProCategories(array $select, array $orderBy);

    /**
     * @param int $id
     * @return array|null
     */
    public function getAllRelatedChildrenIds($id);

    /**
     * @param array $condition
     * @param array $with
     * @param array $select
     * @return mixed
     */
    public function getAllProCategoriesWithChildren(array $condition = [], array $with = [], array $select = ['*']);

    /**
     * @param array $filters
     * @return mixed
     */
    public function getFilters($filters);
}
