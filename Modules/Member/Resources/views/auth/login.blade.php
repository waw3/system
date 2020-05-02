@extends('modules.member::layouts.skeleton')
@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card login-form">
          <div class="card-body">
              <h4 class="text-center">{{ trans('modules.member::dashboard.login-title') }}</h4>
              <br>
            <form method="POST" action="{{ route('public.member.login') }}">
              @csrf
              <div class="form-group">
                  <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ trans('modules.member::dashboard.email') }}" name="email" value="{{ old('email') }}" autofocus>
                  @if ($errors->has('email'))
                    <span class="invalid-feedback">
                <strong>{{ $errors->first('email') }}</strong>
                </span>
                  @endif
                </div>
              <div class="form-group">
                  <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="{{ trans('modules.member::dashboard.password') }}" name="password">
                  @if ($errors->has('password'))
                    <span class="invalid-feedback">
                <strong>{{ $errors->first('password') }}</strong>
                </span>
                  @endif
              </div>
              <div class="form-group">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> {{ trans('modules.member::dashboard.remember-me') }}
                    </label>
                </div>
              </div>
              <div class="form-group mb-0">
                  <button type="submit" class="btn btn-blue btn-full fw6">
                      {{ trans('modules.member::dashboard.login-cta') }}
                  </button>
                  <div class="text-center">
                      <a class="btn btn-link" href="{{ route('public.member.password.request') }}">
                          {{ trans('modules.member::dashboard.forgot-password-cta') }}
                      </a>
                  </div>
              </div>

                <div class="text-center">
                    {!! apply_filters(BASE_FILTER_AFTER_LOGIN_OR_REGISTER_FORM, null, \Modules\Member\Models\Member::class) !!}
                </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@push('scripts')
  <script type="text/javascript" src="{{ asset('vendor/core/packages/js-validation/js/js-validation.js')}}"></script>
  {!! JsValidator::formRequest(\Modules\Member\Http\Requests\LoginRequest::class); !!}
@endpush
