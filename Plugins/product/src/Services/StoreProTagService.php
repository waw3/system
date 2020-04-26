<?php

namespace Modules\Plugins\Product\Services;

use Modules\Base\Events\CreatedContentEvent;
use Modules\Plugins\Product\Models\Product;
use Modules\Plugins\Product\Services\Abstracts\StoreProTagServiceAbstract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreProTagService extends StoreProTagServiceAbstract
{

    /**
     * @param Request $request
     * @param Product $Product
     *
     * @return mixed|void
     */
    public function execute(Request $request, Product $product)
    {
        $protags = $product->protags->pluck('name')->all();

        if (implode(',', $protags) !== $request->input('protag')) {
            $product->protags()->detach();
            $protagInputs = explode(',', $request->input('protag'));
            foreach ($protagInputs as $protagName) {

                if (!trim($protagName)) {
                    continue;
                }

                $protag = $this->protagRepository->getFirstBy(['name' => $protagName]);

                if ($protag === null && !empty($protagName)) {
                    $protag = $this->protagRepository->createOrUpdate([
                        'name'      => $protagName,
                        'author_id' => Auth::user()->getKey(),
                    ]);

                    $request->merge(['slug' => $protagName]);

                    event(new CreatedContentEvent(PROTAG_MODULE_SCREEN_NAME, $request, $protag));
                }

                if (!empty($protag)) {
                    $product->protags()->attach($protag->id);
                }
            }
        }
    }
}
