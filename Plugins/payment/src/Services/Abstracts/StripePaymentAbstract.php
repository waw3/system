<?php

namespace Modules\Plugins\Payment\Services\Abstracts;

use Modules\Plugins\Payment\Supports\StripeHelper;
use Modules\Support\Services\ProduceServiceInterface;
use Modules\Plugins\Payment\Services\Traits\PaymentErrorTrait;
use Exception;
use Illuminate\Http\Request;
use Log;
use Stripe\Charge;
use Stripe\Exception\ApiConnectionException;
use Stripe\Exception\ApiErrorException;
use Stripe\Exception\AuthenticationException;
use Stripe\Exception\CardException;
use Stripe\Exception\InvalidRequestException;
use Stripe\Exception\RateLimitException;
use Stripe\Stripe;

abstract class StripePaymentAbstract implements ProduceServiceInterface
{
    use PaymentErrorTrait;

    /**
     * Token
     *
     * @var string
     */
    protected $token;

    /**
     * Amount of payment
     *
     * @var double
     */
    protected $amount;

    /**
     * Payment currency
     *
     * @var string
     */
    protected $currency;

    /**
     * For Stripe, after make charge successfully, it will return a charge ID for tracking purpose
     * We will store this Charge ID in our DB for tracking purpose
     *
     * @var string
     */
    protected $chargeId;

    /**
     * Make a payment
     *
     * @param Request $request
     *
     * @return mixed
     */
    abstract public function makePayment(Request $request);

    /**
     * Use this function to perform more logic after user has made a payment
     *
     * @param Request $request
     *
     * @return mixed
     */
    abstract public function afterMakePayment(Request $request);

    /**
     * Execute main service
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function execute(Request $request)
    {
        if (!isset($request->stripeToken) || empty($request->stripeToken)) {
            $this->setErrorMessage(trans('modules.plugins.payment::payment.could_not_get_stripe_token'));

            Log::error(
                trans('modules.plugins.payment::payment.could_not_get_stripe_token'),
                StripeHelper::formatLog(
                    [
                        'error'         => 'missing Stripe token',
                        'last_4_digits' => $request->input('last4Digits'),
                        'name'          => $request->input('name'),
                        'client_IP'     => $request->input('clientIP'),
                        'time_created'  => $request->input('timeCreated'),
                        'live_mode'     => $request->input('liveMode'),
                    ],
                    __LINE__,
                    __FUNCTION__,
                    __CLASS__
                )
            );
            return false;
        }

        $this->token = $request->stripeToken;

        try {
            $chargeId = $this->makePayment($request);
        } catch (CardException $exception) {
            $this->setErrorMessageAndLogging($exception, 1); // Since it's a decline, \Stripe\Error\Card will be caught
            return false;
        } catch (RateLimitException $exception) {
            $this->setErrorMessageAndLogging($exception, 2); // Too many requests made to the API too quickly
            return false;
        } catch (InvalidRequestException $exception) {
            $this->setErrorMessageAndLogging($exception, 3); // Invalid parameters were supplied to Stripe's API
            return false;
        } catch (AuthenticationException $exception) {
            $this->setErrorMessageAndLogging($exception,
                4); // Authentication with Stripe's API failed (maybe you changed API keys recently)
            return false;
        } catch (ApiConnectionException $exception) {
            $this->setErrorMessageAndLogging($exception, 5); // Network communication with Stripe failed
            return false;
        } catch (ApiErrorException $exception) {
            $this->setErrorMessageAndLogging($exception,
                6); // Display a very generic error to the user, and maybe send yourself an email
            return false;
        } catch (Exception $exception) {
            $this->setErrorMessageAndLogging($exception, 7); // Something else happened, completely unrelated to Stripe
            return false;
        }

        // Hook after made payment
        if ($chargeId) {
            $this->afterMakePayment($request);
        }

        return $chargeId;
    }

    /**
     * Get payment details
     *
     * @param string $paymentId Stripe payment Id
     * @return mixed Object payment details
     * @throws Exception
     */
    public function getPaymentDetails($paymentId)
    {
        Stripe::setApiKey(setting('payment_stripe_secret'));
        Stripe::setClientId(setting('payment_stripe_client_id'));

        return Charge::retrieve($paymentId);
    }
}
