<?php

namespace Modules\Plugins\RealEstate\Repositories\Caches;

use Modules\Support\Repositories\Caches\CacheAbstractDecorator;
use Modules\Plugins\RealEstate\Repositories\Interfaces\CurrencyInterface;

class CurrencyCacheDecorator extends CacheAbstractDecorator implements CurrencyInterface
{
    /**
     * {@inheritdoc}
     */
    public function getAllCurrencies()
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
