@extends('modules.shortcode::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>
        This view is loaded from module: {!! mconfig('shortcode.name') !!}
    </p>
@endsection
