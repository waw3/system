<meta name="csrf-token" content="{{ csrf_token() }}">

@foreach(mconfig('media.config.libraries.stylesheets', []) as $css)
    <link href="{{ url($css) }}" rel="stylesheet" type="text/css"/>
@endforeach

@include('modules.media::config')
