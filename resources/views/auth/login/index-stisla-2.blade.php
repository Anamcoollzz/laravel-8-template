@extends('stisla.layouts.app-blank')

@section('title')
  {{ $title = __('Masuk') }}
@endsection

@section('content')
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
              <img src="{{ session('_logo_url') }}" alt="{{ session('_app_name') }}" width="100"
                class="shadow-light rounded-circle">
            </div>

            <div class="card card-primary">
              <div class="card-header">
                <h4>{{ $title }}</h4>
              </div>

              <div class="card-body">
                <form method="POST" action="" class="needs-validation" novalidate="">
                  @csrf

                  @include('includes.form.input-email')

                  <div class="form-group">
                    <label for="password">Password
                      <span class="text-danger">*</span>
                    </label>
                    <div class="float-right">
                      <a href="auth-forgot-password.html" class="text-small">
                        {{ __('Lupa Password?') }}
                      </a>
                    </div>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="fas fa-key"></i>
                        </div>
                      </div>
                      <input id="password" name="password" value="" required="" type="password" class="form-control "
                        aria-autocomplete="list">
                    </div>
                    @error('password')
                      <div id="password-error-feedback" class="invalid-feedback" for="password">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>

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
            </div>
            {{-- <div class="mt-5 text-muted text-center">
              Don't have an account? <a href="auth-register.html">Create One</a>
            </div> --}}
            <div class="simple-footer">
              Copyright &copy; {{ ($_since = session('_since')) < date('Y') ? $_since . ' - ' . date('Y') : $_since }}
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection
