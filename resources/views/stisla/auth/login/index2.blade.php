@extends('stisla.layouts.app-auth-simple')

@section('title')
  {{ $title = __('Masuk') }}
@endsection

@section('content')
  <div class="card-body">
    <form method="POST" action="" class="needs-validation" novalidate="">
      @csrf

      @include('stisla.includes.forms.inputs.input-email')
      @include('stisla.auth.login.input-password')

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

    {{-- <div class="text-center mt-4 mb-3">
                  <div class="text-job text-muted">Login With Social</div>
                </div>
                <div class="row sm-gutters">
                  <div class="col-6">
                    <a class="btn btn-block btn-social btn-facebook">
                      <span class="fab fa-facebook"></span> Facebook
                    </a>
                  </div>
                  <div class="col-6">
                    <a class="btn btn-block btn-social btn-twitter">
                      <span class="fab fa-twitter"></span> Twitter
                    </a>
                  </div>
                </div> --}}

  </div>
@endsection
