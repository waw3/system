<?php

declare(strict_types=1);

namespace App\Overrides\Illuminate\Routing;

class Route extends \Illuminate\Routing\Route
{

    /**
     * Get the name of the route instance.
     *
     * @return string|null
     */
    public function getPermission()
    {
        return $this->action['permission'] ?? null;
    }

    /**
     * Add or change the route name.
     *
     * @param  string  $name
     * @return $this
     */
    public function permission($permission)
    {
        $this->action['permission'] = isset($this->action['permission']) ? $this->action['permission'].$permission : $permission;

        return $this;
    }
}
