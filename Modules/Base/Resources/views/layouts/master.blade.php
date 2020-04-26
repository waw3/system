@extends('modules.base::layouts.base')

@section ('page')
    @include('modules.base::layouts.partials.svg-icon')

    <div class="page-wrapper">

        @include('modules.base::layouts.partials.top-header')
        <div class="clearfix"></div>
        <div class="page-container">
            <div class="page-sidebar-wrapper">
                <div class="page-sidebar navbar-collapse collapse">
                    <div class="sidebar">
                        <div class="sidebar-content">
                            <ul class="page-sidebar-menu page-header-fixed" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
                                @include('modules.base::layouts.partials.sidebar')
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="page-content-wrapper">
                <div class="page-content @if (Route::currentRouteName() == 'media.index') rv-media-integrate-wrapper @endif">
                    {!! Breadcrumbs::render('main', page_title()->getTitle(false)) !!}
                    <div class="clearfix"></div>
                    @yield('content')
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        @include('modules.base::layouts.partials.footer')
    </div>
@stop

@section('javascript')
    @include('modules.media::partials.media')
@endsection

@push('footer')
    @routes
@endpush
