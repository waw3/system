<?php

namespace Modules\Plugins\Product\Listeners;

use Modules\Plugins\Product\Repositories\Interfaces\ProCategoryInterface;
use Modules\Plugins\Product\Repositories\Interfaces\ProductInterface;
use Modules\Plugins\Product\Repositories\Interfaces\ProTagInterface;
use SiteMapManager;

class RenderingSiteMapListener
{
    /**
     * @var ProductInterface
     */
    protected $productRepository;

    /**
     * @var CategoryInterface
     */
    protected $procategoryRepository;

    /**
     * @var TagInterface
     */
    protected $protagRepository;

    /**
     * RenderingSiteMapListener constructor.
     * @param ProductInterface $productRepository
     * @param CategoryInterface $categoryRepository
     * @param TagInterface $tagRepository
     */
    public function __construct(
        ProductInterface $productRepository,
        ProCategoryInterface $procategoryRepository,
        ProTagInterface $protagRepository
    ) {
        $this->productRepository = $productRepository;
        $this->procategoryRepository = $procategoryRepository;
        $this->protagRepository = $protagRepository;
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle()
    {
        $products = $this->productRepository->getDataSiteMap();

        foreach ($products as $product) {
            SiteMapManager::add($product->url, $product->updated_at, '0.8', 'daily');
        }

        $procategories = $this->procategoryRepository->getDataSiteMap();

        foreach ($procategories as $procategory) {
            SiteMapManager::add($procategory->url, $procategory->updated_at, '0.8', 'daily');
        }

        $protags = $this->protagRepository->getDataSiteMap();

        foreach ($protags as $protag) {
            SiteMapManager::add($protag->url, $protag->updated_at, '0.3', 'weekly');
        }
    }
}
