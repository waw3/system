<?php

namespace Modules\Plugins\Product\Repositories\Interfaces;

use Modules\Support\Repositories\Interfaces\RepositoryInterface;

interface ProTagInterface extends RepositoryInterface
{

    /**
     * @return array
     */
    public function getDataSiteMap();

    /**
     * @param int $limit
     * @return array
     */
    public function getPopularProTags($limit);

    /**
     * @param bool $active
     * @return array
     */
    public function getAllProTags($active = true);
}
