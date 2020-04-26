<?php

namespace Modules\Plugins\Product\Http\Controllers\API;

use Modules\Base\Enums\BaseStatusEnum;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Plugins\Product\Http\Resources\ProductResource;
use Modules\Plugins\Product\Http\Resources\ListProductResource;
use Modules\Plugins\Product\Repositories\Interfaces\ProductInterface;
use Modules\Plugins\Product\Supports\FilterProduct;
use Modules\Slug\Repositories\Interfaces\SlugInterface;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Plugins\Product\Models\Product;

class ProductController extends Controller
{

    /**
     * @var PostInterface
     */
    protected $postRepository;

    /**
     * @var SlugInterface
     */
    protected $slugRepository;

    /**
     * AuthenticationController constructor.
     *
     * @param PostInterface $postRepository
     */
    public function __construct(ProductInterface $productRepository, SlugInterface $slugRepository)
    {
        $this->productRepository = $productRepository;
        $this->slugRepository = $slugRepository;
    }

    /**
     * List products
     *
     * @group Product
     *
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function index(Request $request, BaseHttpResponse $response)
    {
        $data = $this->productRepository
            ->getModel()
            ->where(['status' => BaseStatusEnum::PUBLISHED])
            ->with(['protags', 'procategories', 'author', 'slugable'])
            ->select([
                'products.id',
                'products.name',
                'products.description',
                'products.content',
                'products.image',
                'products.created_at',
                'products.status',
                'products.updated_at',
                'products.author_id',
                'products.author_type',
            ])
            ->paginate($request->input('per_page', 10));

        return $response
            ->setData(ListProductResource::collection($data))
            ->toApiResponse();
    }

    /**
     * Search product
     *
     * @bodyParam q string required The search keyword.
     *
     * @group Blog
     *
     * @param Request $request
     * @param ProductInterface $productRepository
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws FileNotFoundException
     */
    public function getSearchPro(Request $request, ProductInterface $productRepository, BaseHttpResponse $response)
    {
        $query = $request->input('p');
        $products = $productRepository->getSearchPro($query);

        $data = [
            'items' => $products,
            'query' => $query,
            'count' => $products->count(),
        ];

        if ($data['count'] > 0) {
            return $response->setData(apply_filters(BASE_FILTER_SET_DATA_SEARCHPRO, $data));
        }

        return $response
            ->setError()
            ->setMessage(trans('modules.base::layouts.no_search_result'));
    }

    /**
     * Filters products
     *
     * @group Blog
     * @queryParam page                 Current page of the collection. Default: 1
     * @queryParam per_page             Maximum number of items to be returned in result set.Default: 10
     * @queryParam search               Limit results to those matching a string.
     * @queryParam after                Limit response to products published after a given ISO8601 compliant date.
     * @queryParam author               Limit result set to products assigned to specific authors.
     * @queryParam author_exclude       Ensure result set excludes products assigned to specific authors.
     * @queryParam before               Limit response to products published before a given ISO8601 compliant date.
     * @queryParam exclude              Ensure result set excludes specific IDs.
     * @queryParam include              Limit result set to specific IDs.
     * @queryParam order                Order sort attribute ascending or descending. Default: desc .One of: asc, desc
     * @queryParam order_by             Sort collection by object attribute. Default: updated_at. One of: author, created_at, updated_at, id,  slug, title
     * @queryParam categories           Limit result set to all items that have the specified term assigned in the categories taxonomy.
     * @queryParam categories_exclude   Limit result set to all items except those that have the specified term assigned in the categories taxonomy.
     * @queryParam tags                 Limit result set to all items that have the specified term assigned in the tags taxonomy.
     * @queryParam tags_exclude         Limit result set to all items except those that have the specified term assigned in the tags taxonomy.
     * @queryParam featured             Limit result set to items that are sticky.
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function getFilters(Request $request, BaseHttpResponse $response)
    {
        $filters = FilterProduct::setFilters($request->input());
        $data = $this->productRepository->getFilters($filters);
        return $response
            ->setData(ListProductResource::collection($data))
            ->toApiResponse();
    }

    /**
     * Get product by slug
     *
     * @group Blog
     * @queryParam slug Find by slug of product.
     * @param string $slug
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse|JsonResponse
     */
    public function findBySlug(string $slug, BaseHttpResponse $response)
    {
        $slug = $this->slugRepository->getFirstBy(['key' => $slug, 'reference_type' => Product::class]);
        if (!$slug) {
            return $response->setError()->setCode(404)->setMessage('Not found');
        }

        $product = $this->productRepository->getFirstBy(['id' => $slug->reference_id, 'status' => BaseStatusEnum::PUBLISHED]);
        if (!$product) {
            return $response->setError()->setCode(404)->setMessage('Not found');
        }

        return $response
            ->setData(new ProductResource($product))
            ->toApiResponse();
    }
}
