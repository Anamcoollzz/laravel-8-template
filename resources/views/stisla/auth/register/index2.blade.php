@extends('stisla.layouts.app-auth-simple')

@section('title')
  {{ $title = __('Daftar') }}
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

  </div>
@endsection
