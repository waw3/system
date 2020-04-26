<?php namespace App\Macros\Routes;

use Illuminate\Routing\Router;

/**
 * Macro class.
 */
class RouteJs
{
    const BLACKLIST = 'blacklist';
    const WHITELIST = 'whitelist';

    /**
     * __construct function.
     *
     * @access public
     * @param Router $router
     * @param mixed $list
     * @param mixed $group (default: null)
     * @return void
     */
    public function __construct(Router $router, $list, $group = null)
    {
        $this->list = $list;
        $this->router = $router;
        $this->group = $group;
    }

    /**
     * compile function.
     *
     * @access public
     * @return void
     */
    public function compile()
    {
        if (is_callable($this->group)) {
            $this->router->group(['listed_as' => $this->list], $this->group);
        }

        return $this;
    }

    /**
     * whitelist function.
     *
     * @access public
     * @static
     * @param Router $router
     * @param mixed $group (default: null)
     * @return void
     */
    public static function whitelist(Router $router, $group = null)
    {
        return (new static($router, static::WHITELIST, $group))->compile();
    }

    /**
     * blacklist function.
     *
     * @access public
     * @static
     * @param Router $router
     * @param mixed $group (default: null)
     * @return void
     */
    public static function blacklist(Router $router, $group = null)
    {
        return (new static($router, static::BLACKLIST, $group))->compile();
    }

    /**
     * __call function.
     *
     * @access public
     * @param mixed $method
     * @param mixed $parameters
     * @return void
     */
    public function __call($method, $parameters)
    {
        $route = call_user_func_array([$this->router, $method], $parameters);

        switch ($this->list) {
            case static::BLACKLIST:
                $route->listedAs = 'blacklist';
                break;
            case static::WHITELIST:
                $route->listedAs = 'whitelist';
                break;
        }

        return $route;
    }
}
