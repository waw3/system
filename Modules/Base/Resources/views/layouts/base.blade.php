<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>{{ page_title()->getTitle() }}</title>

    <meta name="robots" content="noindex,follow"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:image" content="{{ setting('admin_logo') ? get_image_url(setting('admin_logo')) : url(mconfig('base.config.logo')) }}">
    <meta name="description" content="{{ strip_tags(trans('modules.base::layouts.copyright', ['year' => now(config('app.timezone'))->format('Y'), 'company' => setting('admin_title', mconfig('base.config.base_name')), 'version' => get_cms_version()])) }}">
    <meta property="og:description" content="{{ strip_tags(trans('modules.base::layouts.copyright', ['year' => now(config('app.timezone'))->format('Y'), 'company' => setting('admin_title', mconfig('base.config.base_name')), 'version' => get_cms_version()])) }}">

    <link rel="icon shortcut" href="{{ setting('admin_favicon') ? get_image_url(setting('admin_favicon'), 'thumb') : url(mconfig('base.config.favicon')) }}">
    <link rel='stylesheet'
          href='//fonts.googleapis.com/css?family=Roboto:100%2C100italic%2C300%2C300italic%2C400%2Citalic%2C500%2C500italic%2C700%2C700italic%2C900%2C900italic|Roboto+Slab:100%2C300%2C400%2C700&#038;subset=greek-ext%2Cgreek%2Ccyrillic-ext%2Clatin-ext%2Clatin%2Cvietnamese%2Ccyrillic'
          type='text/css' media='all'/>

    {!! Assets::renderHeader(['core']) !!}

    @yield('head')

    @stack('header')
</head>
<body class="@yield('body-class', 'page-sidebar-closed-hide-logo page-content-white page-container-bg-solid')" style="@yield('body-style')">

    @yield('page')

    @include('modules.base::elements.common')

    {!! Assets::renderFooter() !!}

    @yield('javascript')

    @stack('footer')
</body>
</html>
