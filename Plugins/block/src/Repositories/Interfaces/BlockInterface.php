<?php

namespace Modules\Plugins\Block\Repositories\Interfaces;

use Modules\Support\Repositories\Interfaces\RepositoryInterface;

interface BlockInterface extends RepositoryInterface
{
    /**
     * @param string $name
     * @param int $id
     * @return mixed
     */
    public function createSlug($name, $id);
}
