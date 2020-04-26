<?php

namespace Modules\Plugins\Product\Services\Abstracts;

use Modules\Plugins\Product\Models\Product;
use Modules\Plugins\Product\Repositories\Interfaces\ProCategoryInterface;
use Illuminate\Http\Request;

abstract class StoreProCategoryServiceAbstract
{
    /**
     * @var CategoryInterface
     */
    protected $procategoryRepository;

    /**
     * StoreCategoryServiceAbstract constructor.
     * @param CategoryInterface $categoryRepository
     */
    public function __construct(ProCategoryInterface $procategoryRepository)
    {
        $this->procategoryRepository = $procategoryRepository;
    }

    /**
     * @param Request $request
     * @param Post $post
     * @return mixed
     */
    abstract public function execute(Request $request, Product $product);
}
