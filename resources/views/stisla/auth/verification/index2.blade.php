@extends('stisla.layouts.app-auth-simple')

@section('title')
  {{ $title = __('Verifikasi Email') }}
@endsection

@section('content')

  <div class="card-body">
    <form method="POST" action="" class="needs-validation" novalidate="">
      @csrf

      @include('stisla.includes.forms.inputs.input-email')

      <div class="form-group">
        <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
          {{ __('Kirim') }}
        </button>
      </div>
    </form>


  </div>

@endsection
