<?php

namespace Modules\Plugins\Product\Services;

use Modules\Plugins\Product\Models\Product;
use Modules\Plugins\Product\Services\Abstracts\StoreProCategoryServiceAbstract;
use Illuminate\Http\Request;

class StoreProCategoryService extends StoreProCategoryServiceAbstract
{

    /**
     * @param Request $request
     * @param Product $Product
     *
     * @return mixed|void
     */
    public function execute(Request $request, Product $product)
    {
        $procategories = $request->input('procategories');
        if (!empty($procategories)) {
            $product->procategories()->detach();
            foreach ($procategories as $procategory) {
                $product->procategories()->attach($procategory);
            }
        }
    }
}
