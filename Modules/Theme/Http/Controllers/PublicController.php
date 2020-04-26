<?php

namespace Modules\Theme\Http\Controllers;

use Modules\Theme\Events\RenderingSingleEvent;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Page\Repositories\Interfaces\PageInterface;
use Modules\Setting\Supports\SettingStore;
use Modules\Slug\Repositories\Interfaces\SlugInterface;
use Modules\Theme\Events\RenderingHomePageEvent;
use Modules\Theme\Events\RenderingSiteMapEvent;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Response;
use SiteMapManager;
use Theme;

class PublicController extends Controller
{
    /**
     * @var SlugInterface
     */
    protected $slugRepository;

    /**
     * @var SettingStore
     */
    protected $settingStore;

    /**
     * PublicController constructor.
     * @param SlugInterface $slugRepository
     * @param SettingStore $settingStore
     */
    public function __construct(SlugInterface $slugRepository, SettingStore $settingStore)
    {
        $this->slugRepository = $slugRepository;
        $this->settingStore = $settingStore;
    }

    /**
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse|\Illuminate\Http\Response|Response
     * @throws FileNotFoundException
     */
    public function getIndex(BaseHttpResponse $response)
    {
        if (defined('PAGE_MODULE_SCREEN_NAME')) {
            $homepage = $this->settingStore->get('show_on_front');
            if ($homepage) {
                $homepage = app(PageInterface::class)->findById($homepage);
                if ($homepage) {
                    return $this->getView($response, $homepage->slug);
                }
            }
        }

        Theme::breadcrumb()->add(__('Home'), url('/'));

        event(RenderingHomePageEvent::class);

        return Theme::scope('index')->render();
    }

    /**
     * @param string $key
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse|Response
     * @throws FileNotFoundException
     */
    public function getView(BaseHttpResponse $response, $key = null)
    {
        if (empty($key)) {
            return $this->getIndex($response);
        }

        $slug = $this->slugRepository->getFirstBy(['key' => $key, 'prefix' => '']);

        if (!$slug) {
            abort(404);
        }

        $result = apply_filters(BASE_FILTER_PUBLIC_SINGLE_DATA, $slug);

        if (isset($result['slug']) && $result['slug'] !== $key) {
            return $response->setNextUrl(route('public.single', $result['slug']));
        }

        event(new RenderingSingleEvent($slug));

        if (!empty($result) && is_array($result)) {
            return Theme::scope($result['view'], $result['data'], Arr::get($result, 'default_view'))->render();
        }

        abort(404);
    }

    /**
     * @return string
     */
    public function getSiteMap()
    {
        event(RenderingSiteMapEvent::class);

        // show your site map (options: 'xml' (default), 'html', 'txt', 'ror-rss', 'ror-rdf')
        return SiteMapManager::render('xml');
    }
}
