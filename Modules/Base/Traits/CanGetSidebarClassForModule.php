<?php

namespace Modules\Base\Traits;

trait CanGetSidebarClassForModule
{
    /**
     * @param string $module
     * @param string $default
     * @return string
     */
    public function getSidebarClassForModule($module, $default)
    {
        if ($this->hasCustomSidebar($module)) {
            $class = config("modules.{$module}.config.custom-sidebar");

            if (class_exists($class) === false) {
                return $default;
            }

            return $class;
        }

        return $default;
    }

    /**
     * hasCustomSidebar function.
     *
     * @access private
     * @param mixed $module
     * @return void
     */
    private function hasCustomSidebar($module)
    {
        return config("modules.{$module}.config.custom-sidebar") !== null;
    }
}
