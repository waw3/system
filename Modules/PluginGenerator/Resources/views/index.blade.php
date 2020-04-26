@extends('modules.plugingenerator::layouts.master')

@section('content')
    <h1>Hello World</h1>

    <p>
        This view is loaded from module: {!! mconfig('plugingenerator.name') !!}
    </p>
@endsection
