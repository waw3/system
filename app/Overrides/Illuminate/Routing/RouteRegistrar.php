<?php

declare(strict_types=1);

namespace App\Overrides\Illuminate\Routing;

use BadMethodCallException;
use Closure;
use Illuminate\Support\Arr;
use Illuminate\Routing\RouteRegistrar as IlluminateRouteRegistrar;


class RouteRegistrar extends IlluminateRouteRegistrar
{

    /**
     * The attributes that can be set through this class.
     *
     * @var array
     */
    protected $allowedAttributes = [
        'as', 'domain', 'middleware', 'name', 'namespace', 'prefix', 'where', 'permission',
    ];

}
