@extends('layouts.app')

@section('title')
  {{ __('Settings') }}
@endsection

@section('content')

  <div class="container-fluid">
    <div class="block-header">
      <h2>{{ __('Settings') }}</h2>
    </div>

    <div class="row clearfix">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
          <div class="header">
            <h2>
              {{ __('Application Setting') }}
              <small>{{ __('A menu that provides settings for the application') }}</small>
            </h2>
            {{-- <ul class="header-dropdown m-r--5"> --}}
            {{-- <li>
                <a href="" data-toggle="tooltip" title="{{ __('Add') }}">
                  <i class="material-icons">add</i>
                </a>
              </li> --}}
            {{-- <li class="dropdown">
                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button"
                  aria-haspopup="true" aria-expanded="false">
                  <i class="material-icons">more_vert</i>
                </a>
                <ul class="dropdown-menu pull-right">
                  <li><a href="javascript:void(0);">Action</a></li>
                  <li><a href="javascript:void(0);">Another action</a></li>
                  <li><a href="javascript:void(0);">Something else here</a></li>
                </ul>
              </li> --}}
            {{-- </ul> --}}
          </div>
          <div class="body">
            <form action="{{ route('settings.update') }}" method="POST">
              @method('put')
              @csrf
              <div class="row clearfix">
                <div class="col-sm-6">
                  @include('includes.form.input', ['id'=>'application_name', 'label'=>__('Application Name'),
                  'value'=>$_application_name->value])
                </div>
                <div class="col-sm-6">
                  @include('includes.form.input', ['id'=>'company_name', 'label'=>__('Company Name'),
                  'value'=>$_company_name->value])
                </div>
                <div class="col-sm-6">
                  @include('includes.form.input', ['id'=>'since', 'label'=>__('Since'),
                  'value'=>$_since->value, 'type'=>'number', 'min'=>2000])
                </div>
                <div class="col-sm-6">
                  @include('includes.form.input', ['id'=>'version', 'label'=>__('Version'),
                  'value'=>$_application_version->value])
                </div>
                <div class="col-sm-6">
                  @include('includes.form.select', ['id'=>'skin', 'label'=>__('Skin'),
                  'value'=>$_skin->value,'options'=>$skins])
                </div>
                <div class="col-md-12">
                  @include('includes.form.buttons.btn-save')
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
