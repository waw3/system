<?php

namespace Modules\Plugins\Product\Http\Controllers;

use Auth;
use Modules\Base\Enums\BaseStatusEnum;
use Modules\Plugins\Product\Models\ProTag;
use Modules\Plugins\Product\Repositories\Interfaces\ProductInterface;
use Modules\Plugins\Product\Repositories\Interfaces\ProTagInterface;
use Modules\SeoHelper\Services\SeoOpenGraph;
use Modules\Slug\Repositories\Interfaces\SlugInterface;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Response;
use SeoHelper;
use Theme;

class PublicController extends Controller
{

    /**
     * @var TagInterface
     */
    protected $protagRepository;

    /**
     * @var SlugInterface
     */
    protected $slugRepository;

    /**
     * PublicController constructor.
     * @param TagInterface $tagRepository
     * @param SlugInterface $slugRepository
     */
    public function __construct(ProTagInterface $protagRepository, SlugInterface $slugRepository)
    {
        $this->protagRepository = $protagRepository;
        $this->slugRepository = $slugRepository;
    }

    /**
     * @param Request $request
     * @param ProductInterface $productRepository
     * @return Response
     * @throws FileNotFoundException
     */
    public function getSearchPro(Request $request, ProductInterface $productRepository)
    {
        $query = $request->input('p');
        SeoHelper::setTitle(__('Search result for: ') . '"' . $query . '"')
            ->setDescription(__('Search result for: ') . '"' . $query . '"');

        $products = $productRepository->getSearchPro($query, 0, 12);

        Theme::breadcrumb()
            ->add(__('Home'), url('/'))
            ->add(__('Search result for: ') . '"' . $query . '"', route('public.searchpro'));

        return Theme::scope('searchpro', compact('products'))->render();
    }

    /**
     * @param string $slug
     * @throws FileNotFoundException
     */
    public function getProTag($slug)
    {
        $slug = $this->slugRepository->getFirstBy(['key' => $slug, 'reference_type' => ProTag::class]);
        if (!$slug) {
            abort(404);
        }
        $condition = [
            'id'     => $slug->reference_id,
            'status' => BaseStatusEnum::PUBLISHED,
        ];

        if (Auth::check() && request('preview')) {
            Arr::forget($condition, 'status');
        }

        $protag = $this->protagRepository->getFirstBy($condition);

        if (!$protag) {
            abort(404);
        }

        SeoHelper::setTitle($protag->name)->setDescription($protag->description);

        $meta = new SeoOpenGraph;
        $meta->setDescription($protag->description);
        $meta->setUrl(route('public.protag', $slug->key));
        $meta->setTitle($protag->name);
        $meta->setType('article');

        if (function_exists('admin_bar')) {
            admin_bar()->registerLink(trans('modules.plugins.product::protags.edit_this_protag'), route('protags.edit', $protag->id));
        }

        $products = get_products_by_protag($protag->id);

        Theme::breadcrumb()->add(__('Home'), url('/'))->add($protag->name, route('public.protag', $slug->key));

        do_action(BASE_ACTION_PUBLIC_RENDER_SINGLE, PROTAG_MODULE_SCREEN_NAME, $protag);

        return Theme::scope('protag', compact('protag', 'products'), 'modules.plugins.product::themes.protag')->render();
    }
}
