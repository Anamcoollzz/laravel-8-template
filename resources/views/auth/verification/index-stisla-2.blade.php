@extends('stisla.layouts.app-blank')

@section('title')
  {{ $title = __('Verifikasi Email') }}
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
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      {{ __('Kirim') }}
                    </button>
                  </div>
                </form>


              </div>
            </div>
            <div class="simple-footer">
              Copyright &copy; {{ ($_since = session('_since')) < date('Y') ? $_since . ' - ' . date('Y') : $_since }}
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection
