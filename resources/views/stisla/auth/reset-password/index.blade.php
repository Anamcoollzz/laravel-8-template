@extends('stisla.layouts.app-blank')

@section('title')
  {{ __('Masuk') }}
@endsection

@section('content')
  <section class="section">
    <div class="d-flex flex-wrap align-items-stretch">
      <div class="col-lg-4 col-md-6 col-12 order-lg-1 min-vh-100 order-2 bg-white">
        <div class="p-4 m-3">
          <div class="align-self-center">
            <img src="{{ $_logo_url }}" alt="{{ $_app_name }}" width="80" class="shadow-light rounded-circle mb-5 mt-2">
            <h4 class="text-dark font-weight-normal">Selamat datang di
              <span class="font-weight-bold">{{ $_app_name }}</span>
            </h4>
            <h5 class="text-dark font-weight-normal">{{ $_company_name }}</h5>
            <p class="text-muted">Sebelum memulai, anda harus masuk terlebih dahulu dengan akun anda.
            </p>
          </div>
          <form method="POST" action="" class="needs-validation" novalidate="">
            @csrf
            @include('includes.form.input-email')
            {{-- @include('includes.form.input-password') --}}

            @include('stisla.auth.login.input-password')

            <div class="form-group">
              <div class="custom-control custom-checkbox">
                <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                <label class="custom-control-label" for="remember-me">{{ __('Ingat Saya') }}</label>
              </div>
            </div>

            <div class="form-group text-right">
              @include('includes.form.buttons.btn-primary', ['icon'=>'fas fa-sign-in-alt', 'label'=>__('Masuk')])
            </div>
          </form>

          <div class="text-center mt-5 text-small">
            Copyright &copy; {{ $_company_name }}. Dibuat dengan 💙 Template Stisla
          </div>
        </div>
      </div>

      @include('stisla.includes.auth.auth-bg')
    </div>
  </section>
@endsection
