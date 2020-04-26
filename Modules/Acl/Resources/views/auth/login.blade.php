@extends('modules.acl::auth.master')

@section('content')


    <p>{{ trans('modules.acl::auth.sign_in_below') }}:</p>


    {!! Form::open(['route' => 'access.login', 'class' => 'login-form']) !!}
        <div class="form-group" id="emailGroup">
            <label>{{ trans('modules.acl::auth.login.username') }}</label>
            {!! Form::text('username', old('username', app()->environment('demo') ? 'botble' : null), ['class' => 'form-control', 'placeholder' => trans('modules.acl::auth.login.username')]) !!}
        </div>

        <div class="form-group" id="passwordGroup">
            <label>{{ trans('modules.acl::auth.login.password') }}</label>
            {!! Form::input('password', 'password', (app()->environment('demo') ? 'password' : null), ['class' => 'form-control', 'placeholder' => trans('modules.acl::auth.login.password')]) !!}
        </div>

        <div>
            <label>
                {!! Form::checkbox('remember', '1', true, ['class' => 'hrv-checkbox']) !!} {{ trans('modules.acl::auth.login.remember') }}
            </label>
        </div>
        <br>

        <button type="submit" class="btn btn-block login-button">
            <span class="signin">{{ trans('modules.acl::auth.login.login') }}</span>
        </button>
        <div class="clearfix"></div>

        <br>
        <p><a class="lost-pass-link" href="{{ route('access.password.request') }}" title="{{ trans('modules.acl::auth.forgot_password.title') }}">{{ trans('modules.acl::auth.lost_your_password') }}</a></p>

        {!!  apply_filters(BASE_FILTER_AFTER_LOGIN_OR_REGISTER_FORM, null, \Modules\Acl\Models\User::class) !!}

    {!! Form::close() !!}
@stop
@push('footer')
    <script>
        var username = document.querySelector('[name="username"]');
        var password = document.querySelector('[name="password"]');
        username.focus();
        document.getElementById('emailGroup').classList.add('focused');

        // Focus events for email and password fields
        username.addEventListener('focusin', function(){
            document.getElementById('emailGroup').classList.add('focused');
        });
        username.addEventListener('focusout', function(){
            document.getElementById('emailGroup').classList.remove('focused');
        });

        password.addEventListener('focusin', function(){
            document.getElementById('passwordGroup').classList.add('focused');
        });
        password.addEventListener('focusout', function(){
            document.getElementById('passwordGroup').classList.remove('focused');
        });
    </script>
@endpush
