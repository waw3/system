<?php

namespace Modules\Plugins\Payment\Repositories\Caches;

use Modules\Support\Repositories\Caches\CacheAbstractDecorator;
use Modules\Plugins\Payment\Repositories\Interfaces\PaymentInterface;

class PaymentCacheDecorator extends CacheAbstractDecorator implements PaymentInterface
{

}
