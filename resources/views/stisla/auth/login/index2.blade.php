@extends('stisla.layouts.app-auth-simple')

@section('title')
  {{ $title = __('Masuk') }}
@endsection

@section('content')
  <div class="card-body">
    <form method="POST" action="{{ route('login-post') }}" class="needs-validation" novalidate="" id="formAuth">
      @csrf

      @include('stisla.includes.forms.inputs.input-email')
      @include('stisla.auth.login.input-password')

      @include('stisla.auth.gcaptcha')

      <div class="form-group">
        <div class="custom-control custom-checkbox">
          <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
          <label class="custom-control-label" for="remember-me">{{ __('Ingat Saya') }}</label>
        </div>
      </div>

      <div class="form-group">
        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
          {{ $title }}
        </button>
      </div>
    </form>

    <div class="row">
      @if ($_is_login_must_verified)
        <div class="col-md-6">
          <a href=" {{ route('send-email-verification') }}" class="text-small">
            {{ __('Belum verifikasi email?') }}
          </a>
        </div>
      @endif
      @if ($_is_active_register_page)
        <div class="col-md-6 @if ($_is_login_must_verified) text-right @endif">
          <a href="{{ route('register') }}" class="text-small text-primary">Belum punya akun?</a>
        </div>
      @endif
    </div>

    @if ($_is_login_with_google || $_is_login_with_facebook || $_is_login_with_twitter)
      <div class="text-center mt-4 mb-3">
        <div class="text-job text-muted">Atau Masuk Dengan</div>
      </div>

      <div class="row">
        <div class="col-md-12" align="center">
          @if ($_is_login_with_google)
            <a href="{{ route('social-login', ['google']) }}" class="btn btn-social-icon btn-facebook mr-1" style="background-color: rgba(220,20,20,1)">
              <i class="fab fa-google"></i>
            </a>
          @endif
          @if ($_is_login_with_facebook)
            <a href="{{ route('social-login', ['facebook']) }}" class="btn btn-social-icon btn-facebook mr-1">
              <i class="fab fa-facebook-f"></i>
            </a>
          @endif
          @if ($_is_login_with_twitter)
            <a href="{{ route('social-login', ['twitter']) }}" class="btn btn-social-icon btn-twitter mr-1">
              <i class="fab fa-twitter"></i>
            </a>
          @endif
        </div>
      </div>

      {{-- <div class="row">
        @if ($_is_login_with_google)
          <div class="col-md-6">
            <a class="btn btn-block btn-social btn-facebook" style="background-color: rgba(220,20,20,1)" href="{{ route('social-login', ['google']) }}">
              <span class="fab fa-google"></span> Google
            </a>
          </div>
        @endif

        @if ($_is_login_with_facebook)
          <div class="col-md-6">
            <a class="btn btn-block btn-social btn-facebook" href="{{ route('social-login', ['facebook']) }}">
              <span class="fab fa-facebook"></span> Facebook
            </a>
          </div>
        @endif
      </div> --}}
    @endif

  </div>
@endsection

@include('stisla.auth.script-gcaptcha')
