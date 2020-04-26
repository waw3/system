<?php

namespace Modules\Plugins\Gallery\Repositories\Interfaces;

use Modules\Support\Repositories\Interfaces\RepositoryInterface;

interface GalleryInterface extends RepositoryInterface
{

    /**
     * Get all galleries.
     *
     * @return mixed
     */
    public function getAll();

    /**
     * @return mixed
     */
    public function getDataSiteMap();

    /**
     * @param $limit
     */
    public function getFeaturedGalleries($limit);
}
