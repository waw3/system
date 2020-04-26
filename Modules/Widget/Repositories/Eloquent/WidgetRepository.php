<?php

namespace Modules\Widget\Repositories\Eloquent;

use Modules\Support\Repositories\Eloquent\RepositoriesAbstract;
use Modules\Widget\Repositories\Interfaces\WidgetInterface;

class WidgetRepository extends RepositoriesAbstract implements WidgetInterface
{
    /**
     * {@inheritdoc}
     */
    public function getByTheme($theme)
    {
        $data = $this->model->where('theme', '=', $theme)->get();
        $this->resetModel();

        return $data;
    }
}
