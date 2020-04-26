<strong>{{ trans('modules.plugins.payment::payment.payment_details') }}: </strong>
@include('modules.plugins.payment::stripe.detail', compact('payment'))
