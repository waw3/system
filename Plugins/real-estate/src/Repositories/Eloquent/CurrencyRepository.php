<?php

namespace Modules\Plugins\RealEstate\Repositories\Eloquent;

use Modules\Support\Repositories\Eloquent\RepositoriesAbstract;
use Modules\Plugins\RealEstate\Repositories\Interfaces\CurrencyInterface;

class CurrencyRepository extends RepositoriesAbstract implements CurrencyInterface
{
    /**
     * {@inheritdoc}
     */
    public function getAllCurrencies()
    {
        $data = $this->model
            ->orderBy('order', 'ASC')
            ->get();

        $this->resetModel();

        return $data;
    }
}
