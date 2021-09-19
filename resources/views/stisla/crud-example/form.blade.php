@extends('stisla.layouts.app')

@section('title')
  {{ $action = isset($d) ? __('Ubah') : __('Tambah') }} {{ $title = 'Contoh CRUD' }}
@endsection

@section('content')
  <div class="section-header">
    <h1>{{ $title }}</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active">
        <a href="{{ route('dashboard.index') }}">{{ __('Dashboard') }}</a>
      </div>
      <div class="breadcrumb-item active">
        <a href="{{ route('crud-examples.index') }}">{{ __('Contoh CRUD') }}</a>
      </div>
      <div class="breadcrumb-item">{{ $action }} {{ $title }}</div>
    </div>
  </div>

  <div class="section-body">
    <h2 class="section-title">{{ $action }} {{ $title }}</h2>
    <p class="section-lead">{{ __('Menampilkan halaman ' . $action . ' ' . $title) }}.</p>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4><i class="fa fa-users"></i> {{ $action }} {{ $title }}</h4>
            {{-- @can('Contoh CRUD') --}}
            <div class="card-header-action">
              @include('stisla.includes.forms.buttons.btn-view', ['link'=>route('crud-examples.index')])
            </div>
            {{-- @endcan --}}
          </div>
          <div class="card-body">
            <form action="{{ isset($d) ? route('crud-examples.update', [$d->id]) : route('crud-examples.store') }}"
              method="POST" enctype="multipart/form-data">

              @isset($d)
                @method('PUT')
              @endisset

              @csrf
              <div class="row">
                <div class="col-md-6">
                  @include('stisla.includes.forms.inputs.input', ['required'=>true, 'name'=>'text', 'label'=>'Text'])
                </div>
                <div class="col-md-6">
                  @include('stisla.includes.forms.inputs.input', ['required'=>true, 'name'=>'number', 'type'=>'number',
                  'label'=>'Number'])
                </div>
                <div class="col-md-6">
                  @include('stisla.includes.forms.selects.select', ['id'=>'select', 'name'=>'select',
                  'options'=>$selectOptions,
                  'label'=>'Select', 'required'=>true])
                </div>
                <div class="col-md-6">
                  @include('stisla.includes.forms.selects.select2', ['id'=>'select2', 'name'=>'select2',
                  'options'=>$selectOptions,
                  'label'=>'Select2', 'required'=>true])
                </div>
                <div class="col-md-6">
                  @include('stisla.includes.forms.selects.select2', ['id'=>'select2_multiple',
                  'name'=>'select2_multiple[]',
                  'options'=>$selectOptions,
                  'label'=>'Select2 Multiple', 'required'=>true, 'multiple'=>true])
                </div>
                <div class="col-md-6">
                  @include('stisla.includes.forms.editors.textarea', ['required'=>true, 'id'=>'textarea',
                  'label'=>'Textarea'])
                </div>
                <div class="col-md-6">
                  @include('stisla.includes.forms.inputs.input-radio-toggle', ['required'=>true, 'id'=>'radio',
                  'label'=>'Radio',
                  'options'=>$selectOptions])
                </div>
                <div class="col-md-6">
                  @include('stisla.includes.forms.inputs.input-chekbox-custom', ['required'=>true, 'id'=>'checkbox',
                  'label'=>'Checkbox',
                  'options'=>$selectOptions])
                </div>
                <div class="col-md-6">
                  @include('stisla.includes.forms.inputs.input', ['required'=>isset($d)?false:true, 'name'=>'file',
                  'type'=>'file',
                  'label'=>'File'])
                </div>
                <div class="col-md-6">
                  @include('stisla.includes.forms.inputs.input', ['required'=>true, 'name'=>'date', 'type'=>'date',
                  'label'=>'Date'])
                </div>
                <div class="col-md-6">
                  @include('stisla.includes.forms.inputs.input', ['required'=>true, 'name'=>'time', 'type'=>'time',
                  'label'=>'Time'])
                </div>
                <div class="col-md-6">
                  @include('stisla.includes.forms.inputs.input-colorpicker', ['required'=>true, 'name'=>'color',
                  'label'=>'Color'])
                </div>
                <div class="col-md-12">
                  <br>
                  @include('stisla.includes.forms.buttons.btn-save')
                  @include('stisla.includes.forms.buttons.btn-reset')
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>

    </div>
  </div>
@endsection
