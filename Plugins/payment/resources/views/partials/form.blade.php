<link rel="stylesheet" href="{{ asset('vendor/core/plugins/payment/libraries/card/card.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/core/plugins/payment/css/payment.css') }}">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<div class="checkout-wrapper">
    <div class="payment-checkout-form">
        <form action="{{ route('payments.checkout') }}" method="post">
            {!! csrf_field() !!}
            <input type="hidden" name="name" value="{{ $name }}">
            <input type="hidden" name="amount" value="{{ $amount }}">
            <input type="hidden" name="currency" value="{{ $currency }}">
            <input type="hidden" name="return_url" value="{{ $returnUrl }}">
            <ul class="list-group list_payment_method">
                @if (setting('payment_offline_status') == 1)
                    <li class="list-group-item">
                        <input class="magic-radio js_payment_method" type="radio" name="payment_method"
                               id="payment_offline" value="offline">
                        <label for="payment_offline" class="text-left">Payment via Bank Transfer</label>
                    </li>
                @endif
                @if (setting('payment_stripe_status') == 1)
                    <li class="list-group-item">
                        <input class="magic-radio js_payment_method" type="radio" name="payment_method"
                               id="payment_stripe"
                               value="stripe" data-toggle="collapse" checked data-target=".payment_stripe_wrap"
                               data-parent=".list_payment_method">
                        <label for="payment_stripe" class="text-left">
                            {{ trans('modules.plugins.payment::payment.payment_via_card') }}
                        </label>
                        <div class="payment_stripe_wrap payment_collapse_wrap collapse show">
                            <div class="card-checkout">
                                <div class="form-group">
                                    <div class="card-wrapper"></div>
                                </div>
                                <div class="form-group @if ($errors->has('number') || $errors->has('expiry')) has-error @endif">
                                    <div class="row">
                                        <div class="col-sm-9">
                                            <input placeholder="{{ trans('modules.plugins.payment::payment.card_number') }}"
                                                   class="form-control" type="text" name="number" data-stripe="number">
                                        </div>
                                        <div class="col-sm-3">
                                            <input placeholder="{{ trans('modules.plugins.payment::payment.mm_yy') }}" class="form-control"
                                                   type="text" name="expiry" data-stripe="exp">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group @if ($errors->has('name') || $errors->has('cvc')) has-error @endif">
                                    <div class="row">
                                        <div class="col-sm-9">
                                            <input placeholder="{{ trans('modules.plugins.payment::payment.full_name') }}"
                                                   class="form-control" type="text" name="name" data-stripe="name">
                                        </div>
                                        <div class="col-sm-3">
                                            <input placeholder="{{ trans('modules.plugins.payment::payment.cvc') }}" class="form-control"
                                                   type="text" name="cvc" data-stripe="cvc">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="payment-stripe-key" data-value="{{ setting('payment_stripe_client_id') }}"></div>
                        </div>
                    </li>
                @endif
                @if (setting('payment_paypal_status') == 1)
                    <li class="list-group-item">
                        <input class="magic-radio js_payment_method" type="radio" name="payment_method"
                               id="payment_paypal"
                               value="paypal">
                        <label for="payment_paypal"
                               class="text-left">{{ trans('modules.plugins.payment::payment.payment_via_paypal') }}</label>
                    </li>
                @endif
            </ul>

            @if (setting('payment_stripe_status') == 1 || setting('payment_paypal_status') == 1 || setting('payment_offline_status') == 1)
                <br>
                <div class="text-center">
                    <button class="payment-checkout-btn btn btn-info">{{ __('Checkout') }}</button>
                </div>


        </form>
        <div class="text-center">
            <button style="display: none" class="payment-offline-btn  btn btn-info" data-toggle="modal"
                    data-target="#bankTransfer">Proceed
            </button>
        </div>
    @endif

    <!-- Modal -->
        <div class="modal fade" id="bankTransfer" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">BANK TRANSFER DETAILS</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h5>Bank Transfer Name</h5>
                        <p>{{setting('payment_offline_name')}}</p>
                        <hr>
                        <h5>Bank Transfer Account Number</h5>
                        <p>{{setting('payment_offline_number')}}</p>
                        <hr>
                        <h5>Bank Transfer Instruction</h5>
                        <p>{{setting('payment_offline_instruction')}}</p>
                    </div>
                    <form action="{{ route('payments.checkout') }}" method="post">
                        {!! csrf_field() !!}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary disableBtn" data-dismiss="modal">Close</button>

                            <input type="hidden" name="name" value="{{ $name }}">
                            <input type="hidden" name="amount" value="{{ $amount }}">
                            <input type="hidden" name="currency" value="{{ $currency }}">
                            <input type="hidden" name="return_url" value="{{ $returnUrl }}">
                            <input class="magic-radio js_payment_method" type="hidden" name="payment_method"
                                   id="payment_offline" value="direct">
                            <button type="button" class="payment-checkout-btn btn btn-info">{{ __('Checkout') }}</button>

                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="{{ asset('vendor/core/plugins/payment/libraries/card/card.js') }}"></script>
<script src="{{ asset('https://js.stripe.com/v2/') }}"></script>
<script src="{{ asset('vendor/core/plugins/payment/js/payment.js') }}"></script>
