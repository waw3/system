<?php

namespace Modules\Plugins\Block\Repositories\Eloquent;

use Modules\Support\Repositories\Eloquent\RepositoriesAbstract;
use Modules\Plugins\Block\Repositories\Interfaces\BlockInterface;
use Illuminate\Support\Str;

class BlockRepository extends RepositoriesAbstract implements BlockInterface
{
    /**
     * {@inheritdoc}
     */
    public function createSlug($name, $id)
    {
        $slug = Str::slug($name);
        $index = 1;
        $baseSlug = $slug;
        while ($this->model->where('alias', $slug)->where('id', '!=', $id)->count() > 0) {
            $slug = $baseSlug . '-' . $index++;
        }

        if (empty($slug)) {
            $slug = time();
        }

        $this->resetModel();

        return $slug;
    }
}
