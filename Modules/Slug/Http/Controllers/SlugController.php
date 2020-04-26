<?php

namespace Modules\Slug\Http\Controllers;

use Modules\Base\Http\Controllers\BaseController;
use Modules\Slug\Http\Requests\SlugRequest;
use Modules\Slug\Repositories\Interfaces\SlugInterface;
use Modules\Slug\Services\SlugService;

class SlugController extends BaseController
{
    /**
     * @var SlugInterface
     */
    protected $slugRepository;

    /**
     * @var SlugService
     */
    protected $slugService;

    /**
     * SlugController constructor.
     * @param SlugInterface $slugRepository
     * @param SlugService $slugService
     */
    public function __construct(SlugInterface $slugRepository, SlugService $slugService)
    {
        $this->slugRepository = $slugRepository;
        $this->slugService = $slugService;
    }

    /**
     * @param SlugRequest $request
     * @return int|string
     */
    public function store(SlugRequest $request)
    {
        return $this->slugService->create($request->input('name'), $request->input('slug_id'),
            $request->input('model'));
    }
}
