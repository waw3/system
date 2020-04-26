<?php

namespace Modules\Plugins\Product\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Modules\Base\Enums\BaseStatusEnum;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Plugins\Product\Http\Resources\ProTagResource;
use Modules\Plugins\Product\Repositories\Interfaces\ProTagInterface;
use Illuminate\Http\Request;

class ProTagController extends Controller
{
    /**
     * @var TagInterface
     */
    protected $protagRepository;

    /**
     * AuthenticationController constructor.
     *
     * @param TagInterface $tagRepository
     */
    public function __construct(ProTagInterface $protagRepository)
    {
        $this->protagRepository = $protagRepository;
    }

    /**
     * List tags
     *
     * @group Product
     *
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function index(Request $request, BaseHttpResponse $response)
    {
        $data = $this->protagRepository
            ->getModel()
            ->where(['status' => BaseStatusEnum::PUBLISHED])
            ->select(['id', 'name', 'description'])
            ->paginate($request->input('per_page', 10));

        return $response
            ->setData(ProTagResource::collection($data))
            ->toApiResponse();
    }
}
