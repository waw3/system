@extends('modules.base::layouts.master')
@section('content')
    @php do_action(BASE_ACTION_TOP_FORM_CONTENT_NOTIFICATION, request(), $payment) @endphp
    <div class="row">
        <div class="col-md-9">
            <div class="widget meta-boxes">
                <div class="widget-title">
                    <h4>
                        <span>{{ trans('modules.plugins.payment::payment.information') }}</span>
                    </h4>
                </div>
                <div class="widget-body">

                    <p>{{ __('Created At') }}: <strong>{{ $payment->created_at }}</strong></p>
                    @if($payment->payment_channel->label() == 'Direct')
                        <p>{{ __('Name') }}: <strong>{{ \Modules\Plugins\Vendor\Models\Vendor::find($payment->user_id)->payments->first()->first_name.' '.\Modules\Plugins\Vendor\Models\Vendor::find($payment->user_id)->payments->first()->last_name }}</strong></p>
                        @endif


@if($payment->payment_channel->label() == 'Direct')
                        <p>{{ __('Package Credit Requested') }}: <strong>{{ $payment->description}}</strong></p>
    @endif

                    <p>{{ __('Payment Channel') }}: <strong>{{ $payment->payment_channel->label() }} Bank Transfer</strong></p>
                    <p>{{ __('Total') }}: <strong>{{ $payment->amount }} {{ $payment->currency }}</strong></p>

                    @if($payment->payment_channel->label() == 'Direct')
                        <p>{{ __('Status') }}: <strong>Pending</strong></p>
                        @endif
                    {!! $detail !!}
                </div>
            </div>
            @php do_action('meta_boxes', 'advanced', $payment) @endphp
        </div>
        <div class="col-md-3 right-sidebar">
            <div class="widget meta-boxes form-actions form-actions-default action-horizontal">
                <div class="widget-title">
                    <h4>
                        <span>{{ trans('modules.plugins.payment::payment.action') }}</span>
                    </h4>
                </div>
                <div class="widget-body">
                    <div class="btn-set">
                        <a href="{{ route('payment.index') }}" class="btn btn-success">
                            <i class="fa fa-check-circle"></i> {{ trans('modules.plugins.payment::payment.go_back') }}
                        </a>
                    </div>
                </div>
            </div>
            @php do_action('meta_boxes', 'side', $payment) @endphp
        </div>
    </div>
@stop
