<?php

namespace Modules\Dashboard\Repositories\Interfaces;

use Modules\Support\Repositories\Interfaces\RepositoryInterface;

interface DashboardWidgetSettingInterface extends RepositoryInterface
{
    /**
     * @return mixed
     *
     * @since 2.1
     */
    public function getListWidget();
}
