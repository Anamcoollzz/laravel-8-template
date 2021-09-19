@extends('stisla.layouts.app')

@section('title')
  {{ $title = 'Profil' }}
@endsection

@section('content')
  @include('stisla.includes.breadcrumbs.breadcrumb-table')

  <div class="section-body">
    <h2 class="section-title">{{ $title }}</h2>
    <p class="section-lead">{{ __('Perbarui kapan saja profil anda di halaman ini') }}.</p>
    <div class="row">
      <div class="col-12">

        @if (config('stisla.versi_demo'))
          @alertinfo
          Dalam versi demo email dan password tidak bisa diubah
          @endalertinfo
        @endif

        <form action="" method="post" enctype="multipart/form-data" class="needs-validation">
          <div class="card">
            <div class="card-header">
              <h4> <i class="fa fa-user"></i> {{ $title }}</h4>
            </div>
            <div class="card-body">
              @method('PUT')
              @csrf
              <div class="row">
                <div class="col-md-6">
                  @include('stisla.includes.forms.inputs.input-name',['value'=>$user->name, 'required'=>true])
                </div>
                <div class="col-md-6">
                  @include('stisla.includes.forms.inputs.input-avatar', ['required'=>false])
                </div>
                <div class="col-md-6">
                  @include('stisla.includes.forms.inputs.input-email', ['value'=>$user->email])
                </div>
                <div class="col-md-12">
                  @include('stisla.includes.forms.buttons.btn-save')
                  @include('stisla.includes.forms.buttons.btn-reset')
                </div>
              </div>
            </div>
          </div>

        </form>

        <h2 class="section-title">{{ __('Perbarui Password') }}</h2>
        <p class="section-lead">{{ __('Perbarui kapan saja password anda di halaman ini') }}.</p>
        <form action="{{ route('profile.update-password') }}" method="post" class="needs-validation">
          <div class="card">
            <div class="card-header">
              <h4> <i class="fa fa-key"></i> {{ __('Perbarui Password') }}</h4>
            </div>
            <div class="card-body">
              @method('PUT')
              @csrf
              <div class="row">
                <div class="col-md-6">
                  @include('stisla.includes.forms.inputs.input-password')
                </div>
                <div class="col-md-12">
                  @include('stisla.includes.forms.buttons.btn-save')
                  @include('stisla.includes.forms.buttons.btn-reset')
                </div>
              </div>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
@endsection
