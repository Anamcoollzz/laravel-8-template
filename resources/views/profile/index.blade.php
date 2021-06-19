@extends('stisla.layouts.app')

@section('title')
  {{ $title = 'Profil' }}
@endsection

@section('content')
  <div class="section-header">
    <h1>{{ $title }}</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active">
        <a href="{{ route('dashboard.index') }}">{{ __('Dashboard') }}</a>
      </div>
      <div class="breadcrumb-item">{{ $title }}</div>
    </div>
  </div>

  <div class="section-body">
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
                  @include('includes.form.input-name',['value'=>$user->name, 'required'=>true])
                </div>
                <div class="col-md-6">
                  @include('includes.form.input-avatar', ['required'=>false])
                </div>
                <div class="col-md-6">
                  @include('includes.form.input-email', ['value'=>$user->email])
                </div>
                <div class="col-md-12">
                  @include('includes.form.buttons.save-btn')
                  @include('includes.form.buttons.btn-reset')
                </div>
              </div>
            </div>
          </div>

        </form>

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
                  @include('includes.form.input-password')
                </div>
                <div class="col-md-12">
                  @include('includes.form.buttons.save-btn')
                  @include('includes.form.buttons.btn-reset')
                </div>
              </div>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
@endsection
