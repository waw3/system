<?php

namespace Modules\Plugins\Product\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Modules\Base\Enums\BaseStatusEnum;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Plugins\Product\Http\Resources\ProCategoryResource;
use Modules\Plugins\Product\Http\Resources\ListProCategoryResource;
use Modules\Plugins\Product\Repositories\Interfaces\ProCategoryInterface;
use Modules\Plugins\Product\Supports\FilterProCategory;
use Modules\Slug\Repositories\Interfaces\SlugInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Plugins\Product\Models\ProCategory;

class ProCategoryController extends Controller
{
    /**
     * @var CategoryInterface
     */
    protected $procategoryRepository;

    /**
     * @var SlugInterface
     */
    protected $slugRepository;

    /**
     * AuthenticationController constructor.
     *
     * @param CategoryInterface $procategoryRepository
     */
    public function __construct(ProCategoryInterface $procategoryRepository, SlugInterface $slugRepository)
    {
        $this->procategoryRepository = $procategoryRepository;
        $this->slugRepository = $slugRepository;
    }

    /**
     * List categories
     *
     * @group Product
     *
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function index(Request $request, BaseHttpResponse $response)
    {
        $data = $this->procategoryRepository
            ->getModel()
            ->where(['status' => BaseStatusEnum::PUBLISHED])
            ->select(['id', 'name', 'description'])
            ->paginate($request->input('per_page', 10));

        return $response
            ->setData(ListProCategoryResource::collection($data))
            ->toApiResponse();
    }

    /**
     * Filters categories
     *
     * @group Product
     *
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function getFilters(Request $request, BaseHttpResponse $response)
    {
        $filters = FilterProCategory::setFilters($request->input());
        $data = $this->procategoryRepository->getFilters($filters);
        return $response
            ->setData(ProCategoryResource::collection($data))
            ->toApiResponse();
    }

    /**
     * Get category by slug
     *
     * @group Product
     * @queryParam slug Find by slug of category.
     * @param string $slug
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse|JsonResponse
     */
    public function findBySlug(string $slug, BaseHttpResponse $response)
    {
        $slug = $this->slugRepository->getFirstBy(['key' => $slug, 'reference_type' => ProCategory::class]);
        if (!$slug) {
            return $response->setError()->setCode(404)->setMessage('Not found');
        }

        $procategory = $this->procategoryRepository->getProCategoryById($slug->reference_id);

        if (!$procategory) {
            return $response->setError()->setCode(404)->setMessage('Not found');
        }

        return $response
            ->setData(new ListProCategoryResource($procategory))
            ->toApiResponse();
    }
}
