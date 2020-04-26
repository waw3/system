<?php

namespace Modules\Plugins\RealEstate\Repositories\Interfaces;

use Modules\Support\Repositories\Interfaces\RepositoryInterface;
use Illuminate\Support\Collection;

interface CurrencyInterface extends RepositoryInterface
{
    /**
     * @return Collection
     */
    public function getAllCurrencies();
}
