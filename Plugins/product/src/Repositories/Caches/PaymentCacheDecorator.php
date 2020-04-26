<?php

namespace Modules\Plugins\Product\Repositories\Caches;

use Modules\Support\Repositories\Caches\CacheAbstractDecorator;
use Modules\Plugins\Product\Repositories\Interfaces\PaymentInterface;

class PaymentCacheDecorator extends CacheAbstractDecorator implements PaymentInterface
{

}