<?php

namespace Modules\Plugins\RequestLog\Repositories\Caches;

use Modules\Support\Repositories\Caches\CacheAbstractDecorator;
use Modules\Plugins\RequestLog\Repositories\Interfaces\RequestLogInterface;

class RequestLogCacheDecorator extends CacheAbstractDecorator implements RequestLogInterface
{

}
