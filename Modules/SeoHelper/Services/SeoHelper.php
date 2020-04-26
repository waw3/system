<?php

namespace Modules\SeoHelper\Services;

use Modules\SeoHelper\Contracts\SeoHelperContract;
use Modules\SeoHelper\Contracts\SeoMetaContract;
use Modules\SeoHelper\Contracts\SeoOpenGraphContract;
use Modules\SeoHelper\Contracts\SeoTwitterContract;
use Exception;

class SeoHelper implements SeoHelperContract
{
    /**
     * The SeoMeta instance.
     *
     * @var \Modules\SeoHelper\Contracts\SeoMetaContract
     */
    private $seoMeta;

    /**
     * The SeoOpenGraph instance.
     *
     * @var \Modules\SeoHelper\Contracts\SeoOpenGraphContract
     */
    private $seoOpenGraph;

    /**
     * The SeoTwitter instance.
     *
     * @var \Modules\SeoHelper\Contracts\SeoTwitterContract
     */
    private $seoTwitter;

    /**
     * Make SeoHelper instance.
     *
     * @param  \Modules\SeoHelper\Contracts\SeoMetaContract $seoMeta
     * @param  \Modules\SeoHelper\Contracts\SeoOpenGraphContract $seoOpenGraph
     * @param  \Modules\SeoHelper\Contracts\SeoTwitterContract $seoTwitter
     */
    public function __construct(
        SeoMetaContract $seoMeta,
        SeoOpenGraphContract $seoOpenGraph,
        SeoTwitterContract $seoTwitter
    ) {
        $this->setSeoMeta($seoMeta);
        $this->setSeoOpenGraph($seoOpenGraph);
        $this->setSeoTwitter($seoTwitter);
        $this->openGraph()->addProperty('type', 'website');
    }

    /**
     * Get SeoMeta instance.
     *
     * @return \Modules\SeoHelper\Contracts\SeoMetaContract
     */
    public function meta()
    {
        return $this->seoMeta;
    }

    /**
     * Set SeoMeta instance.
     *
     * @param  \Modules\SeoHelper\Contracts\SeoMetaContract $seoMeta
     *
     * @return \Modules\SeoHelper\SeoHelper
     */
    public function setSeoMeta(SeoMetaContract $seoMeta)
    {
        $this->seoMeta = $seoMeta;

        return $this;
    }

    /**
     * Get SeoOpenGraph instance.
     *
     * @return \Modules\SeoHelper\Contracts\SeoOpenGraphContract
     */
    public function openGraph()
    {
        return $this->seoOpenGraph;
    }

    /**
     * Get SeoOpenGraph instance.
     *
     * @param  \Modules\SeoHelper\Contracts\SeoOpenGraphContract $seoOpenGraph
     *
     * @return \Modules\SeoHelper\SeoHelper
     */
    public function setSeoOpenGraph(SeoOpenGraphContract $seoOpenGraph)
    {
        $this->seoOpenGraph = $seoOpenGraph;

        return $this;
    }

    /**
     * Get SeoTwitter instance.
     *
     * @return \Modules\SeoHelper\Contracts\SeoTwitterContract
     */
    public function twitter()
    {
        return $this->seoTwitter;
    }

    /**
     * Set SeoTwitter instance.
     *
     * @param  \Modules\SeoHelper\Contracts\SeoTwitterContract $seoTwitter
     *
     * @return \Modules\SeoHelper\SeoHelper
     */
    public function setSeoTwitter(SeoTwitterContract $seoTwitter)
    {
        $this->seoTwitter = $seoTwitter;

        return $this;
    }

    /**
     * Set title.
     *
     * @param  string $title
     * @param  string|null $siteName
     * @param  string|null $separator
     *
     * @return \Modules\SeoHelper\SeoHelper
     */
    public function setTitle($title, $siteName = null, $separator = null)
    {
        $this->meta()->setTitle($title, $siteName, $separator);
        $this->openGraph()->setTitle($title);
        $this->openGraph()->setSiteName($siteName);
        $this->twitter()->setTitle($title);

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->meta()->getTitle();
    }

    /**
     * Set description.
     *
     * @param  string $description
     *
     * @return \Modules\SeoHelper\Contracts\SeoHelperContract
     */
    public function setDescription($description)
    {
        $this->meta()->setDescription($description);
        $this->openGraph()->setDescription($description);
        $this->twitter()->setDescription($description);

        return $this;
    }

    /**
     * Render all seo tags.
     *
     * @return string
     */
    public function render()
    {
        return implode(PHP_EOL, array_filter([
            $this->meta()->render(),
            $this->openGraph()->render(),
            $this->twitter()->render(),
        ]));
    }

    /**
     * Render the tag.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * @param $screen
     * @param \Illuminate\Http\Request $request
     * @param $object
     * @return bool
     *
     */
    public function saveMetaData($screen, $request, $object)
    {
        if (in_array(get_class($object), mconfig('seohelper.config.supported', []))) {
            try {
                if (empty($request->input('seo_meta'))) {
                    delete_meta_data($object, 'seo_meta');
                    return false;
                }
                save_meta_data($object, 'seo_meta', $request->input('seo_meta'));
                return true;
            } catch (Exception $ex) {
                return false;
            }
        }
        return false;
    }

    /**
     * @param $screen
     * @param $object
     * @return bool
     */
    public function deleteMetaData($screen, $object)
    {
        try {
            if (in_array(get_class($object), mconfig('seohelper.config.supported', []))) {
                delete_meta_data($object, 'seo_meta');
            }
            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    /**
     * @param string | array $model
     * @return $this
     */
    public function registerModule($model)
    {
        if (!is_array($model)) {
            $model = [$model];
        }
        config(['modules.seohelper.config.supported' => array_merge(mconfig('seohelper.config.supported', []), $model)]);
        return $this;
    }
}
