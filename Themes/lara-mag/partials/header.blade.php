<header class="header">
    <section class="header-menu-top">
        <section class="container">
            <section class="header-menu-top-left fleft">
                {!!
                    Menu::renderMenuLocation('header-menu', [
                        'options' => ['id' => 'menu-header-top-menu', 'class' => 'menu'],
                        'theme' => true,
                    ])
                !!}
            </section><!-- end .header-menu-top-left -->
            <section class="header-menu-top-right header-social fright">
                <div class="language-wrapper">
                    {!! apply_filters('language_switcher') !!}
                </div>
            </section><!-- end .header-menu-top-right -->
            <section class="cboth"></section><!-- end .cboth -->
        </section><!-- end .container -->
    </section><!-- end .header-menu-top -->
    <section class="header-top">
        <section class="container">
            <h1 class="logo fleft">
                <a href="{{ route('public.single') }}" title="{{ theme_option('site_title') }}">
                    @if (!theme_option('logo'))
                        <span>Lara</span>Mag
                    @else
                        <img src="{{ get_image_url(theme_option('logo')) }}" alt="{{ theme_option('site_title') }}" title="{{ theme_option('site_title') }}"/>
                    @endif
                </a>
            </h1><!-- end .logo -->
            @if (theme_option('banner-ads'))
                <section class="header-banner">
                    <a href="{{ theme_option('banner-link') }}" @if (theme_option('banner-new-tab')) target="_blank" @endif><img src="{{ get_image_url(theme_option('banner-ads')) }}" alt="Banner ads header"/></a>
                </section><!-- end .header-banner -->
            @endif
        </section><!-- end .container -->
    </section><!-- end .header-right-top -->
    <section class="header-bottom">
        <section class="container">
            <a class="icon-home fleft icon-home-active icon-home-active" href="{{ route('public.single') }}"></a>
            <section class="collap-main-nav fleft">
                <img src="{{ Theme::asset()->url('images/icon/collapse.png') }}" alt="Icon Collap"/>
            </section>
            <section class="main-nav fleft">
                <section class="main-nav-inner tf">
                    <section class="close-nav">
                        <i class="fa fa-times" aria-hidden="true"></i> {{ __('Close menu') }}
                    </section><!-- end .close nav -->
                    {!!
                        Menu::renderMenuLocation('main-menu', [
                            'options' => ['id' => 'menu-header-main-menu', 'class' => 'menu'],
                            'theme' => true,
                        ])
                    !!}
                </section><!-- end .main-nav-inner -->
            </section><!-- end .main-nav -->
            <section class="collap-nav-second bsize">
                ...
                {!!
                    Menu::renderMenuLocation('second-menu', [
                        'options' => ['id' => 'menu-header-second-menu', 'class' => 'menu'],
                        'theme' => true,
                    ])
                !!}
            </section><!-- end .collap-nav-second -->
            <section class="cboth"></section><!-- end .cboth -->
        </section><!-- end .container -->
    </section><!-- end .header-bottom -->
</header><!-- end .header -->
