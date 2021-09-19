@extends('stisla.layouts.app')

@section('title')
  {{ isset($d) ? __('Ubah') : __('Tambah') }} {{ $title = 'Mahasiswa' }}
@endsection

@section('content')
  <div class="section-header">
    <h1>{{ $title }}</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active">
        <a href="{{ route('dashboard.index') }}">{{ __('Dashboard') }}</a>
      </div>
      <div class="breadcrumb-item active">
        <a href="{{ route('mahasiswas.index') }}">{{ __('Mahasiswa') }}</a>
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
            <form action="{{ isset($d) ? route('mahasiswas.update', [$d->id]) : route('mahasiswas.store') }}"
              method="POST" enctype="multipart/form-data">

              @isset($d)
                @method('PUT')
              @endisset

              @csrf
              <div class="row">
                <div class="col-md-6">
                  @include('stisla.includes.form.input', ['required'=>true, 'type'=>'text', 'id'=>'name', 'name'=>'name',
                  'label'=>__('Full Name')])
                </div>

                <div class="col-md-6">
                  @include('stisla.includes.form.input', ['required'=>true, 'type'=>'date', 'id'=>'birth_date',
                  'name'=>'birth_date', 'label'=>__('Birth Date')])
                </div>

                <div class="col-md-6">
                  @include('stisla.includes.form.select2', ['required'=>true, 'id'=>'select2', 'name'=>'select2',
                  'label'=>__('Select2'), 'options'=>["anam","devi"], 'multiple'=>true])
                </div>

                <div class="col-md-6">
                  @include('stisla.includes.form.select', ['required'=>true, 'id'=>'select', 'name'=>'select',
                  'label'=>__('Select'), 'options'=>["anam","devi"]])
                </div>

                <div class="col-md-6">
                  @include('stisla.includes.form.colorpicker', ['required'=>true, 'type'=>'text', 'id'=>'colorpicker',
                  'name'=>'colorpicker', 'label'=>__('Colorpicker')])
                </div>

                <div class="col-md-6">
                  @include('stisla.includes.form.input', ['required'=>true, 'type'=>'number', 'id'=>'number',
                  'name'=>'number', 'label'=>__('Number'), 'min'=>0])
                </div>

                <div class="col-md-6">
                  @include('stisla.includes.form.input', ['required'=>true, 'type'=>'file', 'accept'=>'image/*',
                  'id'=>'image', 'name'=>'image', 'label'=>__('Image')])
                </div>

                <div class="col-md-6">
                  @include('stisla.includes.form.input', ['required'=>true, 'type'=>'file', 'accept'=>'*', 'id'=>'file',
                  'name'=>'file', 'label'=>__('File')])
                </div>

                <div class="col-md-6">
                  @include('stisla.includes.form.input-password', ['required'=>true, 'type'=>'text', 'id'=>'password',
                  'name'=>'password', 'label'=>__('Password')])
                </div>

                <div class="col-md-6">
                  @include('stisla.includes.form.input-email', ['required'=>true, 'type'=>'email', 'id'=>'email',
                  'name'=>'email', 'label'=>__('Email')])
                </div>

                <div class="col-md-6">
                  @include('stisla.includes.form.input', ['required'=>true, 'type'=>'time', 'id'=>'time', 'name'=>'time',
                  'label'=>__('Time')])
                </div>

                <div class="col-md-6">
                  @include('stisla.includes.form.textarea', ['required'=>true, 'id'=>'address', 'name'=>'address',
                  'label'=>__('Address')])
                </div>

                <div class="col-md-6">
                  @include('stisla.includes.form.radio-toggle', ['required'=>true, 'id'=>'gender', 'name'=>'gender',
                  'label'=>__('Gender'), 'options'=>["Laki-laki","Perempuan"]])
                </div>


                <div class="col-md-12">
                  <br>
                  @include('stisla.includes.form.buttons.save-btn')
                  @include('stisla.includes.form.buttons.btn-reset')
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>

    </div>
  </div>
@endsection

@push('css')

@endpush

@push('js')

@endpush
