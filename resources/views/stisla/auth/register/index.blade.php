@extends('stisla.layouts.app-auth')

@section('title')
  {{ __('Daftar') }}
@endsection

@section('content')

  <div class="p-4 m-3">
    <div class="align-self-center">
      @include('stisla.includes.auth.auth-header')
      <p class="text-muted">
        {{ __('Sebelum memulai, anda harus mendaftar terlebih dahulu.') }}
      </p>
    </div>
    <form method="POST" action="" class="needs-validation" novalidate="">
      @csrf
      @include('stisla.includes.forms.inputs.input-name')
      @include('stisla.includes.forms.inputs.input-email')
      {{-- @include('stisla.includes.forms.inputs.input-password') --}}

      @include('stisla.includes.forms.inputs.input-password')
      @include('stisla.includes.forms.inputs.input-password', ['id'=>'password_confirmation', 'label'=>'Konfirmasi
      Password'])


      <div class="form-group text-right">
        @include('stisla.includes.forms.buttons.btn-success', ['icon'=>'fas fa-sign-in-alt', 'label'=>__('Sudah punya
        akun'), 'link'=>route('login')])
        @include('stisla.includes.forms.buttons.btn-primary', ['icon'=>'fas fa-sign-in-alt', 'label'=>__('Daftar')])
      </div>
    </form>

    @include('stisla.includes.auth.auth-footer')
  </div>

@endsection
