@extends('stisla.layouts.app')

@section('title')
  {{ isset($d) ? __('Ubah') : __('Tambah') }} {{ $title = 'Data Pengguna' }}
@endsection

@section('content')
  <div class="section-header">
    <h1>{{ $title }}</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active">
        <a href="{{ route('dashboard.index') }}">{{ __('Dashboard') }}</a>
      </div>
      <div class="breadcrumb-item active">
        <a href="{{ route('user-management.users.index') }}">{{ __('Data Pengguna') }}</a>
      </div>
      <div class="breadcrumb-item">{{ isset($d) ? __('Ubah') : __('Tambah') }} {{ $title }}</div>
    </div>
  </div>

  <div class="section-body">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4><i class="fa fa-users"></i> {{ isset($d) ? __('Ubah') : __('Tambah') }} {{ $title }}</h4>
          </div>
          <div class="card-body">
            <form
              action="{{ isset($d) ? route('user-management.users.update', [$d->id]) : route('user-management.users.store') }}"
              method="POST">

              @isset($d)
                @method('PUT')
              @endisset

              @csrf
              <div class="row">
                <div class="col-md-6">
                  @include('includes.form.input-name', ['required'=>true])
                </div>
                <div class="col-md-6">
                  @include('includes.form.input-email')
                </div>
                <div class="col-md-6">
                  @include('includes.form.select', ['id'=>'role', 'name'=>'role', 'options'=>$roleOptions,
                  'label'=>'Role', 'required'=>true])
                </div>
                <div class="col-md-6">
                  @include('includes.form.input-password', ['hint'=>isset($d) ? 'Password bisa dikosongi' : false,
                  'required'=>!isset($d), 'value'=>isset($d)?'':null])
                </div>
                <div class="col-md-12">
                  <br>
                  @include('includes.form.buttons.save-btn')
                  @include('includes.form.buttons.btn-reset')
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>

    </div>
  </div>
@endsection
