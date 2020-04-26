@extends('modules.base::layouts.master')

@section('content')
    <div class="container">
        <div class="row">
            <div class="group flexbox-annotated-section">
                <div class="col-md-3">
                    <h4>{{ trans('modules.plugins.payment::payment.payment_methods') }}</h4>
                    <p>{{ trans('modules.plugins.payment::payment.payment_methods_description') }}</p>
                </div>
                <div class="col-md-9">
                    @php do_action(BASE_ACTION_META_BOXES, 'top', new \Modules\Plugins\Payment\Models\Payment) @endphp
                    @php $paypalStatus = setting('payment_paypal_status'); @endphp
                    <table class="table payment-method-item">
                        <tbody>
                            <tr class="border-pay-row">
                                <td class="border-pay-col"><i class="fa fa-theme-payments"></i></td>
                                <td style="width: 20%;">
                                    <img class="filter-black" src="{{ url('vendor/core/plugins/payment/images/ppcom.svg') }}">
                                </td>
                                <td class="border-right">
                                    <ul>
                                        <li>
                                            <a href="https://paypal.com" target="_blank">PayPal</a>
                                            <p>{{ trans('modules.plugins.payment::payment.paypal_description') }}</p>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                        </tbody>
                        <tbody class="border-none-t">
                        <tr class="bg-white">
                            <td colspan="3">
                                <div class="float-left" style="margin-top: 5px;">
                                    <div class="payment-name-label-group  @if ($paypalStatus== 0) hidden @endif">
                                        <span class="payment-note v-a-t">{{ trans('modules.plugins.payment::payment.use') }}:</span> <label class="ws-nm inline-display method-name-label">{{ setting('payment_paypal_name') }}</label>
                                    </div>
                                </div>
                                <div class="float-right">
                                    <a class="btn btn-secondary toggle-payment-item edit-payment-item-btn-trigger @if ($paypalStatus == 0) hidden @endif">{{ trans('modules.plugins.payment::payment.edit') }}</a>
                                    <a class="btn btn-secondary toggle-payment-item save-payment-item-btn-trigger @if ($paypalStatus == 1) hidden @endif">{{ trans('modules.plugins.payment::payment.settings') }}</a>
                                </div>
                            </td>
                        </tr>
                        <tr class="paypal-online-payment payment-content-item hidden">
                            <td class="border-left" colspan="3">
                                {!! Form::open() !!}
                                {!! Form::hidden('type', \Modules\Plugins\Payment\Enums\PaymentMethodEnum::PAYPAL, ['class' => 'payment_type']) !!}
                                <div class="row">
                                    <div class="col-sm-6">
                                        <ul>
                                            <li>
                                                <label>{{ trans('modules.plugins.payment::payment.configuration_instruction', ['name' => 'PayPal']) }}</label>
                                            </li>
                                            <li class="payment-note">
                                                <p>{{ trans('modules.plugins.payment::payment.configuration_requirement', ['name' => 'PayPal']) }}:</p>
                                                <ul class="m-md-l" style="list-style-type:decimal">
                                                    <li style="list-style-type:decimal">
                                                        <a href="//www.paypal.com/vn/merchantsignup/applicationChecklist?signupType=CREATE_NEW_ACCOUNT&amp;productIntentId=email_payments" target="_blank">
                                                            {{ trans('modules.plugins.payment::payment.service_registration', ['name' => 'PayPal']) }}
                                                        </a>
                                                    </li>
                                                    <li style="list-style-type:decimal">
                                                        <p>{{ trans('modules.plugins.payment::payment.after_service_registration_msg', ['name' => 'PayPal']) }}</p>
                                                    </li>
                                                    <li style="list-style-type:decimal">
                                                        <p>{{ trans('modules.plugins.payment::payment.enter_client_id_and_secret') }}</p>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="well bg-white">
                                            <div class="form-group">
                                                <label class="text-title-field" for="paypal_name">{{ trans('modules.plugins.payment::payment.method_name') }}</label>
                                                <input type="text" class="next-input input-name" name="payment_paypal_name" id="paypal_name" data-counter="400" value="{{ setting('payment_paypal_name', trans('modules.plugins.payment::payment.pay_online_via', ['name' => 'PayPal'])) }}">
                                            </div>
                                            <p class="payment-note">
                                                {{ trans('modules.plugins.payment::payment.please_provide_information') }} <a target="_blank" href="//www.paypal.com">PayPal</a>:
                                            </p>
                                            <div class="form-group">
                                                <label class="text-title-field" for="paypal_client_id">{{ trans('modules.plugins.payment::payment.client_id') }}</label>
                                                <input type="text" class="next-input" name="payment_paypal_client_id" id="paypal_client_id" value="{{ setting('payment_paypal_client_id') }}">
                                            </div>
                                            <div class="form-group">
                                                <label class="text-title-field" for="paypal_client_secret">{{ trans('modules.plugins.payment::payment.client_secret') }}</label>
                                                <div class="input-option">
                                                    <input type="password" class="next-input" placeholder="••••••••" id="paypal_client_secret" name="payment_paypal_client_secret"  value="{{ setting('payment_paypal_client_secret') }}">
                                                </div>
                                            </div>
                                            {!! Form::hidden('payment_paypal_mode', 1) !!}
                                            <div class="form-group">
                                                <label class="next-label">
                                                    <input type="checkbox" class="hrv-checkbox" value="0" name="payment_paypal_mode" @if (setting('payment_paypal_mode') == 0) checked @endif>
                                                    {{ trans('modules.plugins.payment::payment.sandbox_mode') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 bg-white text-right">
                                    <button class="btn btn-warning disable-payment-item @if ($paypalStatus == 0) hidden @endif" type="button">{{ trans('modules.plugins.payment::payment.deactivate') }}</button>
                                    <button class="btn btn-info save-payment-item btn-text-trigger-save @if ($paypalStatus == 1) hidden @endif" type="button">{{ trans('modules.plugins.payment::payment.activate') }}</button>
                                    <button class="btn btn-info save-payment-item btn-text-trigger-update @if ($paypalStatus == 0) hidden @endif" type="button">{{ trans('modules.plugins.payment::payment.update') }}</button>
                                </div>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    @php $stripeStatus = setting('payment_stripe_status'); @endphp
                    <table class="table payment-method-item">
                        <tbody><tr class="border-pay-row">
                            <td class="border-pay-col"><i class="fa fa-theme-payments"></i></td>
                            <td style="width: 20%;">
                                <img class="filter-black" src="{{ url('vendor/core/plugins/payment/images/stripe.svg') }}">
                            </td>
                            <td class="border-right">
                                <ul>
                                    <li>
                                        <a href="https://stripe.com" target="_blank">Stripe</a>
                                        <p>{{ trans('plugins/payment::payment.stripe_description') }}</p>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        </tbody>
                        <tbody class="border-none-t">
                        <tr class="bg-white">
                            <td colspan="3">
                                <div class="float-left" style="margin-top: 5px;">
                                    <div class="payment-name-label-group @if ($stripeStatus == 0) hidden @endif">
                                        <span class="payment-note v-a-t">{{ trans('modules.plugins.payment::payment.use') }}:</span> <label class="ws-nm inline-display method-name-label">{{ setting('payment_stripe_name') }}</label>
                                    </div>
                                </div>
                                <div class="float-right">
                                    <a class="btn btn-secondary toggle-payment-item edit-payment-item-btn-trigger @if ($stripeStatus == 0) hidden @endif">{{ trans('modules.plugins.payment::payment.edit') }}</a>
                                    <a class="btn btn-secondary toggle-payment-item save-payment-item-btn-trigger @if ($stripeStatus == 1) hidden @endif">{{ trans('modules.plugins.payment::payment.settings') }}</a>
                                </div>
                            </td>
                        </tr>
                        <tr class="paypal-online-payment payment-content-item hidden">
                            <td class="border-left" colspan="3">
                                {!! Form::open() !!}
                                {!! Form::hidden('type', \Modules\Plugins\Payment\Enums\PaymentMethodEnum::STRIPE, ['class' => 'payment_type']) !!}
                                <div class="row">
                                    <div class="col-sm-6">
                                        <ul>
                                            <li>
                                                <label>{{ trans('modules.plugins.payment::payment.configuration_instruction', ['name' => 'Stripe']) }}</label>
                                            </li>
                                            <li class="payment-note">
                                                <p>{{ trans('modules.plugins.payment::payment.configuration_requirement', ['name' => 'Stripe']) }}:</p>
                                                <ul class="m-md-l" style="list-style-type:decimal">
                                                    <li style="list-style-type:decimal">
                                                        <a href="https://dashboard.stripe.com/register" target="_blank">
                                                            {{ trans('modules.plugins.payment::payment.service_registration', ['name' => 'Stripe']) }}
                                                        </a>
                                                    </li>
                                                    <li style="list-style-type:decimal">
                                                        <p>{{ trans('modules.plugins.payment::payment.after_service_registration_msg', ['name' => 'Stripe']) }}</p>
                                                    </li>
                                                    <li style="list-style-type:decimal">
                                                        <p>{{ trans('modules.plugins.payment::payment.enter_client_id_and_secret') }}</p>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="well bg-white">
                                            <div class="form-group">
                                                <label class="text-title-field" for="stripe_name">{{ trans('modules.plugins.payment::payment.method_name') }}</label>
                                                <input type="text" class="next-input input-name" name="payment_stripe_name" id="stripe_name" data-counter="400" value="{{ setting('payment_stripe_name', trans('modules.plugins.payment::payment.pay_online_via', ['name' => 'Stripe'])) }}">
                                            </div>
                                            <p class="payment-note">
                                                {{ trans('modules.plugins.payment::payment.please_provide_information') }} <a target="_blank" href="//www.stripe.com">Stripe</a>:
                                            </p>
                                            <div class="form-group">
                                                <label class="text-title-field" for="stripe_key">{{ trans('modules.plugins.payment::payment.client_id') }}</label>
                                                <input type="text" class="next-input" name="payment_stripe_client_id" id="stripe_client_id" value="{{ setting('payment_stripe_client_id') }}">
                                            </div>
                                            <div class="form-group">
                                                <label class="text-title-field" for="stripe_secret">{{ trans('modules.plugins.payment::payment.secret') }}</label>
                                                <div class="input-option">
                                                    <input type="password" class="next-input" placeholder="••••••••" id="stripe_secret" name="payment_stripe_secret" value="{{ setting('payment_stripe_secret') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 bg-white text-right">
                                    <button
                                        class="btn btn-warning disable-payment-item @if ($stripeStatus == 0) hidden @endif"
                                        type="button">{{ trans('modules.plugins.payment::payment.deactivate') }}</button>
                                    <button
                                        class="btn btn-info save-payment-item btn-text-trigger-save @if ($stripeStatus == 1) hidden @endif"
                                        type="button">{{ trans('modules.plugins.payment::payment.activate') }}</button>
                                    <button
                                        class="btn btn-info save-payment-item btn-text-trigger-update @if ($stripeStatus == 0) hidden @endif"
                                        type="button">{{ trans('modules.plugins.payment::payment.update') }}</button>
                                </div>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                        </tbody>
                    </table>

                    @php $OfflineStatus = setting('payment_offline_status'); @endphp
                    <table class="table payment-method-item">
                        <tbody>
                        <tr class="border-pay-row">
                            <td class="border-pay-col"><i class="fa fa-theme-payments"></i></td>
                            <td style="width: 20%;">
                                <img class="filter-black"
                                     src="{{ url('vendor/core/plugins/payment/images/bank.svg') }}">
                            </td>
                            <td class="border-right">
                                <ul>
                                    <li>
                                        <a href="#" target="_blank">Bank Transfer</a>
                                        <p>Customer can buy product and pay directly using any local bank in their
                                            region</p>
                                    </li>
                                </ul>
                            </td>
                        </tr>
                        </tbody>
                        <tbody class="border-none-t">
                        <tr class="bg-white">
                            <td colspan="3">
                                <div class="float-left" style="margin-top: 5px;">
                                    <div class="payment-name-label-group @if ($OfflineStatus == 0) hidden @endif">
                                        <span
                                            class="payment-note v-a-t">{{ trans('plugins/payment::payment.use') }}:</span>
                                        <label class="ws-nm inline-display method-name-label">Bank Transfer</label>
                                    </div>
                                </div>
                                <div class="float-right">
                                    <a class="btn btn-secondary toggle-payment-item edit-payment-item-btn-trigger @if ($OfflineStatus == 0) hidden @endif">{{ trans('modules.plugins.payment::payment.edit') }}</a>
                                    <a class="btn btn-secondary toggle-payment-item save-payment-item-btn-trigger @if ($OfflineStatus == 1) hidden @endif">{{ trans('modules.plugins.payment::payment.settings') }}</a>
                                </div>
                            </td>
                        </tr>
                        <tr class="paypal-online-payment payment-content-item hidden">
                            <td class="border-left" colspan="3">
                                {!! Form::open() !!}
                                <input class="payment_type" name="type" type="hidden" value="offline">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <ul>
                                            <li>
                                                <label>{{ trans('modules.plugins.payment::payment.configuration_instruction', ['name' => 'Bank Transfer']) }}</label>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="well bg-white">
                                            <div class="form-group">
                                                <label class="text-title-field" for="offline_name">Bank Transfer
                                                    Name</label>
                                                <input type="text" class="next-input input-name"
                                                       name="payment_offline_name" id="offline_name" data-counter="400"
                                                       value="{{ setting('payment_offline_name', trans('modules.plugins.payment::payment.pay_online_via', ['name' => 'offline'])) }}">
                                            </div>
                                            <div class="form-group">
                                                <label class="text-title-field" for="offline_number">Bank Transfer
                                                    Account Number</label>
                                                <input type="text" class="next-input input-name"
                                                       name="payment_offline_number" id="offline_number"
                                                       data-counter="400"
                                                       value="{{ setting('payment_offline_number', trans('modules.plugins.payment::payment.pay_online_via', ['name' => 'offline'])) }}">
                                            </div>
                                            <div class="form-group">
                                                <label class="text-title-field" for="offline_instruction">Bank Transfer
                                                    Instruction</label>
                                                <textarea type="text" class="next-input input-name"
                                                          name="payment_offline_instruction" id="offline_instruction"
                                                          data-counter="400">{{ setting('payment_offline_instruction', trans('modules.plugins.payment::payment.pay_online_via', ['name' => 'offline'])) }}
                                                </textarea></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 bg-white text-right">
                                    <button
                                        class="btn btn-warning disable-payment-item @if ($OfflineStatus == 0) hidden @endif"
                                        type="button">{{ trans('modules.plugins.payment::payment.deactivate') }}</button>
                                    <button
                                        class="btn btn-info save-payment-item btn-text-trigger-save @if ($OfflineStatus == 1) hidden @endif"
                                        type="button">{{ trans('modules.plugins.payment::payment.activate') }}</button>
                                    <button
                                        class="btn btn-info save-payment-item btn-text-trigger-update @if ($OfflineStatus == 0) hidden @endif"
                                        type="button">{{ trans('modules.plugins.payment::payment.update') }}</button>
                                </div>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @php do_action(BASE_ACTION_META_BOXES, 'main', new \Modules\Plugins\Payment\Models\Payment) @endphp
            <div class="group">
                <div class="col-md-3">

                </div>
                <div class="col-md-9">
                    @php do_action(BASE_ACTION_META_BOXES, 'advanced', new \Modules\Plugins\Payment\Models\Payment) @endphp
                </div>
            </div>
        </div>
    </div>
    {!! Form::modalAction('confirm-disable-payment-method-modal', trans('modules.plugins.payment::payment.deactivate_payment_method'), 'info', trans('modules.plugins.payment::payment.deactivate_payment_method_description'), 'confirm-disable-payment-method-button', trans('modules.plugins.payment::payment.agree')) !!}
    <div data-disable-payment-url="{{ route('payments.methods.update.status') }}"></div>
    <div data-update-payment-url="{{ route('payments.methods') }}"></div>
@stop
