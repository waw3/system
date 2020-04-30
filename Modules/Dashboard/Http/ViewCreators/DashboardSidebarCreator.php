<?php

namespace Modules\Dashboard\Http\ViewCreators;

use Illuminate\View\View;
use Modules\Dashboard\Sidebar\DashboardSidebar;
use Maatwebsite\Sidebar\Presentation\SidebarRenderer;

class DashboardSidebarCreator
{
    /**
     * @var \Modules\Dashboard\Sidebar\DashboardSidebar
     */
    protected $sidebar;

    /**
     * @var \Maatwebsite\Sidebar\Presentation\SidebarRenderer
     */
    protected $renderer;

    /**
     * @param \Modules\Dashboard\Sidebar\DashboardSidebar $sidebar
     * @param \Maatwebsite\Sidebar\Presentation\SidebarRenderer $renderer
     */
    public function __construct(DashboardSidebar $sidebar, SidebarRenderer $renderer)
    {
        $this->sidebar = $sidebar;
        $this->renderer = $renderer;
    }

    /**
     * create function.
     *
     * @access public
     * @param View $view
     * @return void
     */
    public function create(View $view)
    {
        $view->sidebar = $this->renderer->render($this->sidebar);
    }
}
