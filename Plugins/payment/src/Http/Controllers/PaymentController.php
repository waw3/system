<?php

namespace Modules\Plugins\Payment\Http\Controllers;

use Assets;
use Modules\Base\Events\DeletedContentEvent;
use Modules\Base\Http\Responses\BaseHttpResponse;
use Modules\Plugins\Payment\Enums\PaymentMethodEnum;
use Modules\Plugins\Payment\Http\Requests\PaymentMethodRequest;
use Modules\Plugins\Payment\Repositories\Interfaces\PaymentInterface;
use Modules\Plugins\Payment\Services\Gateways\PayPal\PayPalPaymentService;
use Modules\Plugins\Payment\Services\Gateways\Stripe\StripePaymentService;
use Modules\Plugins\Payment\Tables\PaymentTable;
use Modules\Setting\Supports\SettingStore;
use DateTime;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Throwable;

class PaymentController extends Controller
{
    /**uuid
     * @var PayPalPaymentService
     */
    protected $payPalService;

    /**
     * @var StripePaymentService
     */
    protected $stripePaymentService;

    /**
     * @var string
     */
    protected $returnUrl;

    /**
     * @var PaymentInterface
     */
    protected $paymentRepository;

    /**
     * PaymentController constructor.
     * @param PayPalPaymentService $payPalService
     * @param StripePaymentService $stripePaymentService
     * @param PaymentInterface $paymentRepository
     */
    public function __construct(
        PayPalPaymentService $payPalService,
        StripePaymentService $stripePaymentService,
        PaymentInterface $paymentRepository
    ) {
        $this->payPalService = $payPalService;

        $this->stripePaymentService = $stripePaymentService;
        $this->paymentRepository = $paymentRepository;

        $this->returnUrl = config('modules.plugins.payment.payment.return_url_after_payment');
    }

    /**
     * @param PaymentTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(PaymentTable $table)
    {
        page_title()->setTitle(trans('modules.plugins.payment::payment.name'));

        return $table->renderTable();
    }


    /**
     * @param $id
     * @param Request $request
     * @return BaseHttpResponse
     */
    public function destroy(Request $request, $id, BaseHttpResponse $response)
    {
        try {
            $payment = $this->paymentRepository->findOrFail($id);

            $this->paymentRepository->delete($payment);

            event(new DeletedContentEvent(PAYMENT_MODULE_SCREEN_NAME, $request, $payment));

            return $response->setMessage(trans('modules.base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage(trans('modules.base::notices.cannot_delete'));
        }
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws Exception
     */
    public function deletes(Request $request, BaseHttpResponse $response)
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return $response
                ->setError()
                ->setMessage(trans('modules.base::notices.no_select'));
        }

        foreach ($ids as $id) {
            $payment = $this->paymentRepository->findOrFail($id);
            $this->paymentRepository->delete($payment);
            event(new DeletedContentEvent(PAYMENT_MODULE_SCREEN_NAME, $request, $payment));
        }

        return $response->setMessage(trans('modules.base::notices.delete_success_message'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Redirector
     */
    public function postCheckout(Request $request,BaseHttpResponse $response)
    {
        $error = false;
        $errorMessage = null;

        $currency = $request->input('currency', config('modules.plugins.payment.payment.currency'));
        $currency = strtoupper($currency);

        $data = [
            'amount'   => $request->input('amount'),
            'currency' => $currency,
            'type'     => $request->input('payment_method'),
        ];

        switch ($request->input('payment_method')) {
            case PaymentMethodEnum::STRIPE:
                $result = $this->stripePaymentService
                    ->execute($request);
                if (!$result) {
                    $error = true;
                    $errorMessage = $this->stripePaymentService->getErrorMessage();
                }

                $data['paymentId'] = $result;
                break;
            case PaymentMethodEnum::PAYPAL:
                $checkoutUrl = $this->payPalService->execute($request);

                if ($checkoutUrl) {
                    return redirect($checkoutUrl);
                } else {
                    $error = true;
                    $errorMessage = $this->payPalService->getErrorMessage();
                }

                break;
            case PaymentMethodEnum::DIRECT:
                $userData = auth()->guard('vendor')->user();
                $date = new DateTime();
                $this->paymentRepository->insert(
                    [
                        'amount' => $request->amount,
                        'payment_channel' => 'direct',
                        'currency' => $request->currency,
                        'charge_id' => 'Bank_' . mt_rand(1000000, 9999999),
                        'user_id' => $userData->id,
                        'description' => $request->name,
                         'created_at' => $date->format('Y-m-d H:i:s')
                    ]
                );


                break;
            default:
                break;
        }

        if (PaymentMethodEnum::DIRECT == 'direct'){

            return redirect()->to('/contact')->with('success_msg', 'Your Transaction is been processed');
        }else{
            $returnUrl = $request->input('return_url') . '?' . http_build_query($data);
            if ($error) {
                return redirect()->back()->with('error_msg', $errorMessage);
            }

            return redirect()->to($returnUrl)->with('success_msg', trans('modules.plugins.payment::payment.checkout_success'));
        }




    }

    /**
     * Show edit form
     *
     * @param int id
     * @return Factory|View
     * @throws Exception
     * @throws Throwable
     */
    public function show($id)
    {
        $payment = $this->paymentRepository->findOrFail($id);

        $detail = null;
        switch ($payment->payment_channel) {
            case 'paypal':
                $paymentDetail = $this->payPalService->getPaymentDetails($payment->charge_id);
                $detail = view('modules.plugins.payment::paypal.detail', ['payment' => $paymentDetail])->render();
                break;
            case 'stripe':
                $paymentDetail = $this->stripePaymentService->getPaymentDetails($payment->charge_id);
                $detail = view('modules.plugins.payment::stripe.detail', ['payment' => $paymentDetail])->render();
                break;

        }
        return view('modules.plugins.payment::show', compact('payment', 'detail'));
    }

    /**
     * @return Factory|View
     */
    public function methods()
    {
        page_title()->setTitle(trans('modules.plugins.payment::payment.payment_methods'));

        Assets::addStylesDirectly('vendor/core/plugins/payment/css/payment-methods.css')
            ->addScriptsDirectly('vendor/core/plugins/payment/js/payment-methods.js');

        return view('modules.plugins.payment::settings.index');
    }

    /**
     * @param PaymentMethodRequest $request
     * @param BaseHttpResponse $response
     * @param SettingStore $settingStore
     * @return BaseHttpResponse
     */
    public function updateMethods(PaymentMethodRequest $request, BaseHttpResponse $response, SettingStore $settingStore)
    {
        $type = $request->input('type');
        $data = $request->except(['_token', 'type']);
        foreach ($data as $settingKey => $settingValue) {
            $settingStore
                ->set($settingKey, $settingValue);
        }

        $settingStore
            ->set('payment_' . $type . '_status', 1)
            ->save();

        return $response->setMessage(__('Saved payment method successfully!'));
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @param SettingStore $settingStore
     * @return BaseHttpResponse
     */
    public function updateMethodStatus(Request $request, BaseHttpResponse $response, SettingStore $settingStore)
    {
        $settingStore
            ->set('payment_' . $request->input('type') . '_status', 0)
            ->save();

        return $response->setMessage(__('Turn off payment method successfully!'));
    }
}
