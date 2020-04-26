<?php

namespace Modules\Base\Http\Middleware;

use BaseHttpResponse;
use Closure;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;

class DisableInDemoModeMiddleware
{

    /**
     * @var \Illuminate\Foundation\Application|mixed
     */
    protected $app;

    /**
     * @var BaseHttpResponse
     */
    protected $httpResponse;

    /**
     * DisableInDemoModeMiddleware constructor.
     * @param Application $application
     * @param BaseHttpResponse $response
     */
    public function __construct(Application $application, BaseHttpResponse $response)
    {
        $this->app = $application;
        $this->httpResponse = $response;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     *
     * @since 2.1
     */
    public function handle($request, Closure $next)
    {
        if (app()->environment('demo')) {
            return $this->httpResponse
                ->setError()
                ->withInput()
                ->setMessage(trans('modules.base::system.disabled_in_demo_mode'))
                ->toResponse($request);
        }

        return $next($request);
    }
}
