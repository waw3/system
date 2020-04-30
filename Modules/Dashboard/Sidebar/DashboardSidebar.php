<?php

namespace Modules\Dashboard\Sidebar;

use Illuminate\Contracts\Container\Container;
use Maatwebsite\Sidebar\{Menu, ShouldCache, Sidebar};
use Maatwebsite\Sidebar\Traits\CacheableTrait;
use Nwidart\Modules\Facades\Module;
use Nwidart\Modules\Contracts\RepositoryInterface as Modules;
use Modules\Base\Events\BuildingSidebar;

class DashboardSidebar implements Sidebar, ShouldCache
{

    use CacheableTrait;

    /**
     * The menu instance.
     *
     * @var \Maatwebsite\Sidebar\Menu
     */
    protected $menu;


    /**
     * Create a new sidebar instance.
     *
     * @param \Maatwebsite\Sidebar\Menu $menu
     * @return void
     */
    public function __construct(Menu $menu)
    {
        $this->menu = $menu;
    }


    /**
     * Build the sidebar menu.
     *
     * @return void
     */
    public function build()
    {
//         event($event = new BuildingSidebar($this->menu));
        $this->addActiveThemeExtender();
        $this->addModuleExtenders();
    }


    /**
     * Add sidebar extender to the menu.
     *
     * @param string $extender
     * @return void
     */
    private function add($extender)
    {
        if (class_exists($extender)) {
            resolve($extender)->extend($this->menu);
        }

        $this->menu->add($this->menu);
    }

    /**
     * Get the built menu.
     *
     * @return \Maatwebsite\Sidebar\Menu
     */
    public function getMenu()
    {
        $this->build();

        return $this->menu;
    }

    /**
     * Check if the module has a custom sidebar class configured
     * @param string $module
     * @return bool
     */
    private function hasCustomSidebar($module)
    {
        $config = mconfig("{$module}.config.custom-sidebar");

        return $config !== null;
    }




    /**
     * Add active theme's sidebar extender.
     *
     * @return void
     */
    private function addActiveThemeExtender()
    {
/*
        $theme = setting('active_theme');

        $this->add("Themes\\{$theme}\\Sidebar\\SidebarExtender");
*/
    }

    /**
     * Add all enabled modules sidebar extender.
     *
     * @return void
     */
    private function addModuleExtenders()
    {
        foreach (Module::allEnabled() as $module) {
            $this->add("Modules\\{$module->getName()}\\Sidebar\\SidebarExtender");
        }

/*
        foreach ($this->modules->enabled() as $module) {
            $lowercaseModule = strtolower($module->get('name'));
            if ($this->hasCustomSidebar($lowercaseModule) === true) {
                $class = mconfig("{$lowercaseModule}.config.custom-sidebar");
                $this->addToSidebar($class);
                continue;
            }

            $name = $module->get('name');
            $class = 'Modules\\' . $name . '\\Sidebar\\SidebarExtender';
            $this->addToSidebar($class);
        }
*/
    }

        /**
     * Add the given class to the sidebar collection
     * @param string $class
     */
/*
    private function addToSidebar($class)
    {
        if (class_exists($class) === false) {
            return;
        }
        $extender = $this->container->make($class);

        $this->menu->add($extender->extendWith($this->menu));
    }
*/



}
