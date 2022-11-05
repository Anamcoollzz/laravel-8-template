@extends('stisla.layouts.app-auth-simple')

@section('title')
  {{ $title = __('Lupa Password') }}
@endsection

@section('content')
  <div class="card-body">
    <form method="POST" action="" class="needs-validation" novalidate="" id="formAuth">
      @csrf
      @include('stisla.includes.forms.inputs.input-email')

      @include('stisla.auth.gcaptcha')

      <div class="form-group">
        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
          {{ __('Kirim') }}
        </button>
      </div>
    </form>
  </div>
@endsection

@include('stisla.auth.script-gcaptcha')
