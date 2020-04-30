<?php

namespace Modules\Dashboard\Sidebar;


class BaseSidebarExtender
{
    protected $auth;

    public function __construct()
    {
        $this->auth = auth();
    }
}
