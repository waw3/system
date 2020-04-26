<?php

namespace Modules\Plugins\Product\Repositories\Caches;

use Modules\Support\Repositories\Caches\CacheAbstractDecorator;
use Modules\Plugins\Product\Repositories\Interfaces\CartInterface;

class CartCacheDecorator extends CacheAbstractDecorator implements CartInterface
{

}
