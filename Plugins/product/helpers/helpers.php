<?php

use Modules\Base\Enums\BaseStatusEnum;
use Modules\Base\Supports\SortItemsWithChildrenHelper;
use Modules\Plugins\Product\Repositories\Interfaces\ProCategoryInterface;
use Modules\Plugins\Product\Repositories\Interfaces\ProductInterface;
use Modules\Plugins\Product\Repositories\Interfaces\ProTagInterface;
use Modules\Plugins\Product\Supports\ProductFormat;
use Illuminate\Support\Arr;

if (!function_exists('get_featured_products')) {
    /**
     * @param int $limit
     * @return array
     */
    function get_featured_products($limit)
    {
        return app(ProductInterface::class)->getFeatured($limit);
    }
}

if (!function_exists('get_latest_products')) {
    /**
     * @param int $limit
     * @param array $excepts
     * @return array
     */
    function get_latest_products($limit, $excepts = [])
    {
        return app(ProductInterface::class)->getListProductNonInList($excepts, $limit);
    }
}

if (!function_exists('get_related_products')) {
    /**
     * @param string $currentSlug
     * @param int $limit
     * @return array
     */
    function get_related_products($currentSlug, $limit)
    {
        return app(ProductInterface::class)->getRelated($currentSlug, $limit);
    }
}

if (!function_exists('get_products_by_procategory')) {
    /**
     * @param int $
     * @param int $paginate
     * @param int $limit
     * @return array
     */
    function get_products_by_procategory($procategoryId, $paginate = 12, $limit = 0)
    {
        return app(ProductInterface::class)->getByProCategory($procategoryId, $paginate, $limit);
    }
}

if (!function_exists('get_products_by_tag')) {
    /**
     * @param string $slug
     * @param int $paginate
     * @return array
     */
    function get_products_by_tag($slug, $paginate = 12)
    {
        return app(ProductInterface::class)->getByTag($slug, $paginate);
    }
}

if (!function_exists('get_products_by_user')) {
    /**
     * @param $authorId
     * @param int $paginate
     * @return array
     */
    function get_products_by_user($authorId, $paginate = 12)
    {
        return app(ProductInterface::class)->getByUserId($authorId, $paginate);
    }
}

if (!function_exists('get_all_products')) {
    /**
     * @param boolean $active
     * @param int $perPage
     * @return array
     */
    function get_all_products($active = true, $perPage = 12)
    {
        return app(ProductInterface::class)->getAllProducts($perPage, $active);
    }
}

if (!function_exists('get_recent_products')) {
    /**
     * @param int $limit
     * @return array
     */
    function get_recent_products($limit)
    {
        return app(ProductInterface::class)->getRecentProducts($limit);
    }
}

if (!function_exists('get_featured_categories')) {
    /**
     * @param int $limit
     * @return array
     */
    function get_featured_categories($limit)
    {
        return app(ProCategoryInterface::class)->getFeaturedProCategories($limit);
    }
}

if (!function_exists('get_all_categories')) {
    /**
     * @param array $condition
     * @return array
     */
    function get_all_categories(array $condition = [])
    {
        return app(ProCategoryInterface::class)->getAllProCategories($condition);
    }
}

if (!function_exists('get_all_protags')) {
    /**
     * @param boolean $active
     * @return array
     */
    function get_all_protags($active = true)
    {
        return app(ProTagInterface::class)->getAllProTags($active);
    }
}

if (!function_exists('get_popular_protags')) {
    /**
     * @param integer $limit
     * @return array
     */
    function get_popular_protags($limit = 10)
    {
        return app(ProTagInterface::class)->getPopularProTags($limit);
    }
}

if (!function_exists('get_popular_products')) {
    /**
     * @param integer $limit
     * @param array $args
     * @return array
     */
    function get_popular_products($limit = 10, array $args = [])
    {
        return app(ProductInterface::class)->getPopularProducts($limit, $args);
    }
}

if (!function_exists('get_procategory_by_id')) {
    /**
     * @param integer $id
     * @return array
     */
    function get_procategory_by_id($id)
    {
        return app(ProCategoryInterface::class)->getProCategoryById($id);
    }
}




if (!function_exists('get_procategories')) {
    /**
     * @param array $args
     * @return array|mixed
     */
    function get_procategories(array $args = [])
    {
        $indent = Arr::get($args, 'indent', '——');

        $repo = app(ProCategoryInterface::class);

        $procategories = $repo->getProCategories(Arr::get($args, 'select', ['*']), [
            'procategories.is_default' => 'DESC',
            'procategories.order'      => 'ASC',
        ]);

        $procategories = sort_item_with_children($procategories);

        foreach ($procategories as $procategory) {
            $indentText = '';
            $depth = (int)$procategory->depth;
            for ($i = 0; $i < $depth; $i++) {
                $indentText .= $indent;
            }
            $procategory->indent_text = $indentText;
        }

        return $procategories;
    }
}

if (!function_exists('get_procategories_with_children')) {
    /**
     * @return array
     * @throws Exception
     */
    function get_procategories_with_children()
    {
        $categories = app(ProCategoryInterface::class)
            ->getAllProCategoriesWithChildren(['status' => BaseStatusEnum::PUBLISHED], [], ['id', 'name', 'parent_id']);
        $sortHelper = app(SortItemsWithChildrenHelper::class);
        $sortHelper
            ->setChildrenProperty('child_cats')
            ->setItems($categories);

        return $sortHelper->sort();
    }
}

if (!function_exists('register_product_format')) {
    /**
     * @param array $formats
     * @return void
     */
    function register_product_format(array $formats)
    {
        ProductFormat::registerProductFormat($formats);
    }
}

if (!function_exists('get_product_formats')) {
    /**
     * @param bool $convertToList
     * @return array
     */
    function get_product_formats($convertToList = false)
    {
        return ProductFormat::getProductFormats($convertToList);
    }
}
