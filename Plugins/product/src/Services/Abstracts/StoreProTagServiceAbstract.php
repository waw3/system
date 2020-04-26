<?php

namespace Modules\Plugins\Product\Services\Abstracts;

use Modules\Plugins\Product\Models\Product;
use Modules\Plugins\Product\Repositories\Interfaces\ProTagInterface;
use Illuminate\Http\Request;

abstract class StoreProTagServiceAbstract
{
    /**
     * @var TagInterface
     */
    protected $protagRepository;

    /**
     * StoreTagService constructor.
     * @param TagInterface $tagRepository
     */
    public function __construct(ProTagInterface $protagRepository)
    {
        $this->protagRepository = $protagRepository;
    }

    /**
     * @param Request $request
     * @param Product $Product
     * @return mixed
     */
    abstract public function execute(Request $request, Product $product);
}
