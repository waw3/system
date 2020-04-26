<?php

declare(strict_types=1);

namespace App\Overrides\Illuminate\Http;

use Illuminate\Http\Request as BaseRequest;

class Request extends BaseRequest
{
    /**
     * Get the URL (no query string) for the request.
     *
     * @return string
     */
    public function url(): string
    {
        return parent::url().(mconfig('core.config.route.trailing_slash') ? '/' : '');
    }
}
