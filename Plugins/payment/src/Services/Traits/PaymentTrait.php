<?php

namespace Modules\Plugins\Payment\Services\Traits;

use Auth;
use Modules\Plugins\Payment\Repositories\Interfaces\PaymentInterface;
use Illuminate\Support\Arr;

trait PaymentTrait
{

    /**
     * Store payment on local
     *
     * @param array $args
     * @return mixed
     */
    public function storeLocalPayment(array $args = [])
    {
        $data = array_merge([
            'user_id' => Auth::check() ? Auth::user()->id : 0,
        ], $args);

        $paymentChannel = Arr::get($data, 'payment_channel', 'stripe');

        app(PaymentInterface::class)->create([
            'account_id'      => Arr::get($data, 'account_id'),
            'amount'          => $data['amount'],
            'currency'        => $data['currency'],
            'charge_id'       => $data['charge_id'],
            'payment_channel' => $paymentChannel,
        ]);
    }
}
