@extends('stisla.layouts.app-auth')

@section('title')
  {{ $title = __('Reset Password') }}
@endsection

@section('content')
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            @include('stisla.includes.auth.logo')

            <div class="card card-primary">
              <div class="card-header">
                <h4>{{ $title }}</h4>
              </div>

              <div class="card-body">
                <form method="POST" action="" class="needs-validation" novalidate="">
                  @csrf

                  @include('includes.form.input-password', ['label'=>'Password Baru', 'id'=>'new_password'])
                  @include('includes.form.input-password', ['label'=>'Konfirmasi Password Baru',
                  'id'=>'new_password_confirmation'])

                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      {{ __('Atur Ulang') }}
                    </button>
                  </div>
                </form>


              </div>
            </div>
            @include('stisla.includes.auth.simple-footer')
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection
