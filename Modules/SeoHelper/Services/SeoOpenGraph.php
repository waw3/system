<?php

namespace Modules\SeoHelper\Services;

use Modules\SeoHelper\Contracts\Entities\OpenGraphContract;
use Modules\SeoHelper\Contracts\SeoOpenGraphContract;

class SeoOpenGraph implements SeoOpenGraphContract
{

    /**
     * The Open Graph instance.
     *
     * @var \Modules\SeoHelper\Contracts\Entities\OpenGraphContract
     */
    protected $openGraph;

    /**
     * Make SeoOpenGraph instance.
     */
    public function __construct()
    {
        $this->setOpenGraph(
            new \Modules\SeoHelper\Entities\OpenGraph\Graph
        );
    }

    /**
     * Set the Open Graph instance.
     *
     * @param  \Modules\SeoHelper\Contracts\Entities\OpenGraphContract $openGraph
     *
     * @return \Modules\SeoHelper\Services\SeoOpenGraph
     */
    public function setOpenGraph(OpenGraphContract $openGraph)
    {
        $this->openGraph = $openGraph;

        return $this;
    }

    /**
     * Set the open graph prefix.
     *
     * @param  string $prefix
     *
     * @return \Modules\SeoHelper\Services\SeoOpenGraph
     */
    public function setPrefix($prefix)
    {
        $this->openGraph->setPrefix($prefix);

        return $this;
    }

    /**
     * Set type property.
     *
     * @param  string $type
     *
     * @return \Modules\SeoHelper\Services\SeoOpenGraph
     */
    public function setType($type)
    {
        $this->openGraph->setType($type);

        return $this;
    }

    /**
     * Set title property.
     *
     * @param  string $title
     *
     * @return \Modules\SeoHelper\Services\SeoOpenGraph
     */
    public function setTitle($title)
    {
        $this->openGraph->setTitle($title);

        return $this;
    }

    /**
     * Set description property.
     *
     * @param  string $description
     *
     * @return \Modules\SeoHelper\Services\SeoOpenGraph
     */
    public function setDescription($description)
    {
        $this->openGraph->setDescription($description);

        return $this;
    }

    /**
     * Set url property.
     *
     * @param  string $url
     *
     * @return \Modules\SeoHelper\Services\SeoOpenGraph
     */
    public function setUrl($url)
    {
        $this->openGraph->setUrl($url);

        return $this;
    }

    /**
     * Set image property.
     *
     * @param  string $image
     *
     * @return \Modules\SeoHelper\Services\SeoOpenGraph
     */
    public function setImage($image)
    {
        $this->openGraph->setImage($image);

        return $this;
    }

    /**
     * Set site name property.
     *
     * @param  string $siteName
     *
     * @return \Modules\SeoHelper\Services\SeoOpenGraph
     */
    public function setSiteName($siteName)
    {
        $this->openGraph->setSiteName($siteName);

        return $this;
    }

    /**
     * Add many open graph properties.
     *
     * @param  array $properties
     *
     * @return \Modules\SeoHelper\Services\SeoOpenGraph
     */
    public function addProperties(array $properties)
    {
        $this->openGraph->addProperties($properties);

        return $this;
    }

    /**
     * Add an open graph property.
     *
     * @param  string $property
     * @param  string $content
     *
     * @return \Modules\SeoHelper\Services\SeoOpenGraph
     */
    public function addProperty($property, $content)
    {
        $this->openGraph->addProperty($property, $content);

        return $this;
    }

    /**
     * Render the tag.
     *
     * @return string
     */
    public function render()
    {
        return $this->openGraph->render();
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
}
