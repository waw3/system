<?php namespace Modules\DevTool\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * SeedGen class.
 *
 * @extends Facade
 */
class SeedGen extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'seedgen';
    }
}
