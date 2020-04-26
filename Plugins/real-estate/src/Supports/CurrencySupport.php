<?php

namespace Modules\Plugins\RealEstate\Supports;

use Modules\Plugins\RealEstate\Models\Currency;
use Modules\Plugins\RealEstate\Repositories\Interfaces\CurrencyInterface;

class CurrencySupport
{
    /**
     * @var Currency
     */
    protected $currency;

    /**
     * @param Currency $currency
     */
    public function setApplicationCurrency(Currency $currency)
    {
        $this->currency = $currency;

        if (session('currency') == $currency->id) {
            return;
        }
        session(['currency' => $currency->id]);
    }

    /**
     * @return Currency
     */
    public function getApplicationCurrency()
    {
        $currency = $this->currency;

        if (empty($currency)) {
            $currency = app(CurrencyInterface::class)->getFirstBy(['is_default' => 1]);

            if (!$currency) {
                $currency = new Currency;
            }

            $this->currency = $currency;
        }

        $this->setApplicationCurrency($currency);

        return $currency;
    }
}
