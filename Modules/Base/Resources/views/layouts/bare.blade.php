@extends('modules.base::layouts.base')

@section ('page')
    <div class="page-wrapper">

        @include('modules.base::layouts.partials.top-header')

        <div class="page-container">
            <div class="page-content" style="background-color: transparent;">
                @yield('content')
            </div>
            <div class="clearfix"></div>
        </div>

        @include('modules.base::layouts.partials.footer')

    </div>
@stop
