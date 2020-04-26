@extends('modules.base::errors.master')

@section('content')

    <div style="margin: 50px;">
        <div class="col-md-10">
            <h3>{{ trans('modules.base::errors.401_title') }}</h3>
            <p>{{ trans('modules.base::errors.reasons') }}</p>
            <ul>
                {!! trans('modules.base::errors.401_msg') !!}
            </ul>

            <p>{!! trans('modules.base::errors.try_again') !!}</p>
        </div>
    </div>

@stop
