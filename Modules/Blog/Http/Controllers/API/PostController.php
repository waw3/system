<?php

namespace Modules\Blog\Http\Controllers\API;

use Modules\Base\Enums\BaseStatusEnum;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Blog\Http\Resources\PostResource;
use Modules\Blog\Http\Resources\ListPostResource;
use Modules\Blog\Repositories\Interfaces\PostInterface;
use Modules\Blog\Supports\FilterPost;
use Modules\Slug\Repositories\Interfaces\SlugInterface;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Blog\Models\Post;

class PostController extends Controller
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
    public function __construct(PostInterface $postRepository, SlugInterface $slugRepository)
    {
        $this->postRepository = $postRepository;
        $this->slugRepository = $slugRepository;
    }

    /**
     * List posts
     *
     * @group Blog
     *
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function index(Request $request, BaseHttpResponse $response)
    {
        $data = $this->postRepository
            ->getModel()
            ->where(['status' => BaseStatusEnum::PUBLISHED])
            ->with(['tags', 'categories', 'author', 'slugable'])
            ->select([
                'posts.id',
                'posts.name',
                'posts.description',
                'posts.content',
                'posts.image',
                'posts.created_at',
                'posts.status',
                'posts.updated_at',
                'posts.author_id',
                'posts.author_type',
            ])
            ->paginate($request->input('per_page', 10));

        return $response
            ->setData(ListPostResource::collection($data))
            ->toApiResponse();
    }

    /**
     * Search post
     *
     * @bodyParam q string required The search keyword.
     *
     * @group Blog
     *
     * @param Request $request
     * @param PostInterface $postRepository
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws FileNotFoundException
     */
    public function getSearch(Request $request, PostInterface $postRepository, BaseHttpResponse $response)
    {
        $query = $request->input('q');
        $posts = $postRepository->getSearch($query);

        $data = [
            'items' => $posts,
            'query' => $query,
            'count' => $posts->count(),
        ];

        if ($data['count'] > 0) {
            return $response->setData(apply_filters(BASE_FILTER_SET_DATA_SEARCH, $data));
        }

        return $response
            ->setError()
            ->setMessage(trans('modules.base::layouts.no_search_result'));
    }

    /**
     * Filters posts
     *
     * @group Blog
     * @queryParam page                 Current page of the collection. Default: 1
     * @queryParam per_page             Maximum number of items to be returned in result set.Default: 10
     * @queryParam search               Limit results to those matching a string.
     * @queryParam after                Limit response to posts published after a given ISO8601 compliant date.
     * @queryParam author               Limit result set to posts assigned to specific authors.
     * @queryParam author_exclude       Ensure result set excludes posts assigned to specific authors.
     * @queryParam before               Limit response to posts published before a given ISO8601 compliant date.
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
        $filters = FilterPost::setFilters($request->input());
        $data = $this->postRepository->getFilters($filters);
        return $response
            ->setData(ListPostResource::collection($data))
            ->toApiResponse();
    }

    /**
     * Get post by slug
     *
     * @group Blog
     * @queryParam slug Find by slug of post.
     * @param string $slug
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse|JsonResponse
     */
    public function findBySlug(string $slug, BaseHttpResponse $response)
    {
        $slug = $this->slugRepository->getFirstBy(['key' => $slug, 'reference_type' => Post::class]);
        if (!$slug) {
            return $response->setError()->setCode(404)->setMessage('Not found');
        }

        $post = $this->postRepository->getFirstBy(['id' => $slug->reference_id, 'status' => BaseStatusEnum::PUBLISHED]);
        if (!$post) {
            return $response->setError()->setCode(404)->setMessage('Not found');
        }

        return $response
            ->setData(new PostResource($post))
            ->toApiResponse();
    }
}
