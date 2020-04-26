<?php

namespace Modules\Plugins\Payment\Services\Gateways\PayPal;

use Modules\Plugins\Payment\Enums\PaymentMethodEnum;
use Modules\Plugins\Payment\Services\Abstracts\PayPalPaymentAbstract;
use Modules\Plugins\Payment\Services\Traits\PaymentTrait;
use Exception;
use Illuminate\Http\Request;

class PayPalPaymentService extends PayPalPaymentAbstract
{
    use PaymentTrait;

    /**
     * Make a payment
     *
     * @param Request $request
     *
     * @return mixed
     * @throws Exception
     */
    public function makePayment(Request $request)
    {
        $amount = $request->input('amount');

        $data = [
            'name'     => $request->input('name'),
            'quantity' => 1,
            'price'    => $amount,
            'sku'      => null,
            'type'     => PaymentMethodEnum::PAYPAL,
        ];

        $currency = $request->input('currency', config('modules.plugins.payment.payment.currency'));
        $currency = strtoupper($currency);

        $queryParams = [
            'type' => PaymentMethodEnum::PAYPAL,
            'amount' => $amount,
            'currency' => $currency,
        ];

        $checkoutUrl = $this
            ->setReturnUrl($request->input('return_url') . '?' . http_build_query($queryParams))
            ->setCurrency($currency)
            ->setItem($data)
            ->createPayment($request->input('description'));

        return $checkoutUrl;
    }

    /**
     * Use this function to perform more logic after user has made a payment
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function afterMakePayment(Request $request)
    {
        $this->storeLocalPayment([
            'amount'         => $request->input('amount'),
            'currency'       => $request->input('currency'),
            'charge_id'      => $request->input('paymentId'),
            'payment_channel' => PaymentMethodEnum::PAYPAL,
        ]);

        return true;
    }
}
