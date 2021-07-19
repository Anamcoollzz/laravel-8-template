@extends('stisla.layouts.app')

@section('title')
  {{ $title = __('Settings') }}
@endsection

@section('content')

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
        <div class="card">
          <div class="card-header">
            <h4><i class="fa fa-cogs"></i> {{ $title }} Umum</h4>

          </div>
          <div class="card-body">
            <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
              <input type="hidden" name="type" value="umum">
              @method('put')
              @csrf
              <div class="row clearfix">
                <div class="col-sm-6">
                  @include('includes.form.input', ['id'=>'application_name', 'label'=>__('Application Name'),
                  'value'=>$_application_name->value, 'required'=>true])
                </div>
                <div class="col-sm-6">
                  @include('includes.form.input', ['id'=>'company_name', 'label'=>__('Company Name'),
                  'value'=>$_company_name->value, 'required'=>true])
                </div>
                <div class="col-sm-6">
                  @include('includes.form.input', ['id'=>'since', 'label'=>__('Since'),
                  'value'=>$_since->value, 'type'=>'number', 'min'=>2000, 'required'=>true])
                </div>
                <div class="col-sm-6">
                  @include('includes.form.input', ['id'=>'application_version', 'label'=>__('Version'),
                  'value'=>$_application_version->value, 'required'=>true])
                </div>

                <div class="col-md-12">
                  @include('includes.form.buttons.save-btn')
                  @include('includes.form.buttons.reset-btn')
                </div>
              </div>
            </form>
          </div>
        </div>

        <div class="card">
          <div class="card-header">
            <h4><i class="fa fa-eye"></i> {{ __('Pengaturan Tampilan') }}</h4>

          </div>
          <div class="card-body">
            <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
              <input type="hidden" name="type" value="tampilan">
              @method('put')
              @csrf
              <div class="row clearfix">
                <div class="col-sm-6">
                  {{-- {{ dd($activeSkin->value) }} --}}
                  @include('includes.form.select', ['id'=>'stisla_skin', 'label'=>__('Skin'),
                  'selected'=>$activeSkin->value, 'options'=>$skins, 'required'=>true])
                </div>
                <div class="col-sm-6">
                  @include('includes.form.select', ['id'=>'login_template', 'label'=>__('Tampilan Halaman Masuk'),
                  'selected'=>\App\Models\Setting::firstOrCreate(['key'=> 'login_template'], ['value'=>'default'])->value,
                  'options'=>['default'=>'default', 'tampilan 2'=>'tampilan 2'],
                  'required'=>true])
                </div>
                <div class="col-sm-6">
                  @include('includes.form.select', ['id'=>'stisla_sidebar_mini', 'label'=>__('Sidebar Mini'),
                  'selected'=>\App\Models\Setting::firstOrCreate(['key'=> 'stisla_sidebar_mini'], ['value'=>'0'])->value,
                  'options'=>['0'=>'Tidak', '1'=>'Ya'],
                  'required'=>true])
                </div>
                <div class="col-sm-6">
                  @include('includes.form.input', ['id'=>'favicon', 'label'=>__('Favicon'),
                  'required'=>false, 'accept'=>'image/x-icon', 'type'=>'file'])
                </div>
                <div class="col-md-12">
                  @include('includes.form.buttons.save-btn')
                  @include('includes.form.buttons.reset-btn')
                </div>
              </div>
            </form>
          </div>
        </div>

        <div class="card">
          <div class="card-header">
            <h4><i class="fa fa-envelope"></i> {{ __('Pengaturan Email') }}</h4>

          </div>
          <div class="card-body">
            <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
              <input type="hidden" name="type" value="email">
              @method('put')
              @csrf
              <div class="row clearfix">
                <div class="col-sm-6">
                  @include('includes.form.input-email', ['id'=>'mail_from_address', 'label'=>__('From Address'),
                  'required'=>true,
                  'value'=>old('mail_from_address')??\App\Models\Setting::firstOrCreate(['key'=>'mail_from_address'],
                  ['value'=>'hairulanam21@gmail.com'])->value])
                </div>
                <div class="col-sm-6">
                  @include('includes.form.input-name', ['id'=>'mail_from_name', 'label'=>__('From Name'),
                  'required'=>true,
                  'value'=>old('mail_from_name')??\App\Models\Setting::firstOrCreate(['key'=>'mail_from_name'],
                  ['value'=>'Superadmin '.session('_app_name')])->value])
                </div>
                <div class="col-sm-6">
                  @include('includes.form.input', ['id'=>'mail_host', 'label'=>__('SMTP Host'),
                  'required'=>true,
                  'value'=>old('mail_host')??\App\Models\Setting::firstOrCreate(['key'=>'mail_host'],
                  ['value'=>'smtp.mailtrap.io'])->value])
                </div>
                <div class="col-sm-6">
                  @include('includes.form.input', ['id'=>'mail_port', 'label'=>__('SMTP Port'),
                  'required'=>true,
                  'value'=>old('mail_port')??\App\Models\Setting::firstOrCreate(['key'=>'mail_port'],
                  ['value'=>'2525'])->value])
                </div>
                <div class="col-sm-6">
                  @include('includes.form.input', ['id'=>'mail_username', 'label'=>__('SMTP Username'),
                  'required'=>true,
                  'value'=>old('mail_username')??\App\Models\Setting::firstOrCreate(['key'=>'mail_username'],
                  ['value'=>'809d58dfa23ade'])->value])
                </div>
                <div class="col-sm-6">
                  @include('includes.form.input', ['id'=>'mail_password', 'label'=>__('SMTP Password'),
                  'required'=>true,
                  'value'=>old('mail_password')??\App\Models\Setting::firstOrCreate(['key'=>'mail_password'],
                  ['value'=>'e9d1aa54a61db1'])->value])
                </div>
                <div class="col-sm-6">
                  @include('includes.form.input', ['id'=>'mail_encryption', 'label'=>__('SMTP Encryption'),
                  'required'=>true,
                  'value'=>old('mail_encryption')??\App\Models\Setting::firstOrCreate(['key'=>'mail_encryption'],
                  ['value'=>'tls'])->value])
                </div>
                <div class="col-md-12">
                  @include('includes.form.buttons.save-btn')
                  @include('includes.form.buttons.reset-btn')
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>

    </div>
  </div>

@endsection
