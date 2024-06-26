@extends('modules.base::layouts.base')

@section('body-class') login @stop
@section('body-style') background-image: url({{ url(Arr::random(mconfig('acl.config.backgrounds', []))) }}); @stop

@push('header')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
@endpush
@section ('page')
    <div class="container-fluid">
        <div class="row">
            <div class="faded-bg animated"></div>
            <div class="hidden-xs col-sm-7 col-md-8">
                <div class="clearfix">
                    <div class="col-sm-12 col-md-10 col-md-offset-2">
                        <div class="logo-title-container">
                            <div class="copy animated fadeIn">
                                <h1>{{ setting('admin_title') }}</h1>
                                <p>{!! trans('modules.base::layouts.copyright', ['year' => now(config('app.timezone'))->format('Y'), 'company' => setting('admin_title', mconfig('base.config.base_name')), 'version' => get_cms_version()]) !!}</p>
                                <div class="copyright">
                                    @if (setting('enable_multi_language_in_admin') != false && count(Assets::getAdminLocales()) > 1)
                                        <p> {{ trans('modules.acl::auth.languages') }}:
                                            @foreach (Assets::getAdminLocales() as $key => $value)
                                                <span @if (app()->getLocale() == $key) class="active" @endif>
                                                    <a href="{{ route('settings.language', $key) }}">
                                                        {!! language_flag($value['flag'], $value['name']) !!} <span>{{ $value['name'] }}</span>
                                                    </a>
                                                </span>
                                            @endforeach
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div> <!-- .logo-title-container -->
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-sm-5 col-md-4 login-sidebar">

                <div class="login-container">

                    @yield('content')

                    <div style="clear:both"></div>

                </div> <!-- .login-container -->

            </div> <!-- .login-sidebar -->
        </div> <!-- .row -->
    </div>
@stop
