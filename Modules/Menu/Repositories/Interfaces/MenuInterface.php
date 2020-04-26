<?php

namespace Modules\Menu\Repositories\Interfaces;

use Modules\Support\Repositories\Interfaces\RepositoryInterface;

interface MenuInterface extends RepositoryInterface
{

    /**
     * @param $slug
     * @param $active
     * @param $selects
     * @return mixed
     */
    public function findBySlug($slug, $active, $selects = []);

    /**
     * @param $name
     * @return mixed
     */
    public function createSlug($name);
}
