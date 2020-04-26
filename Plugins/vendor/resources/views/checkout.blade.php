@extends('modules.plugins.vendor::layouts.skeleton')
@section('content')
    <div class="settings">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xs-12">
                    {!! do_shortcode('[payment-form currency="USD" amount="' . $package->usd_price . '" name="' . $package->name . '" return_url="' . route('public.vendor.package.subscribe.callback', $package->id) . '"][/payment-form]') !!}
                </div>
            </div>
        </div>
    </div>
@stop
