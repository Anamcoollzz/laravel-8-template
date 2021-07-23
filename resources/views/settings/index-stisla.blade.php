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
                <div class="col-sm-12">
                  @include('includes.form.select', ['id'=>'mail_provider', 'options'=>['mailtrap'=>'mailtrap',
                  'mailgun'=>'mailgun', 'smtp'=>'smtp biasa',], 'label'=>__('Pilih Provider'), 'required'=>true,
                  'selected'=>$mailProvider =
                  old('mail_provider')??\App\Repositories\EmailRepository::emailProvider()])
                </div>
                <div class="col-sm-6">
                  @include('includes.form.input-email', ['id'=>'mail_from_address', 'label'=>__('From Address'),
                  'required'=>true,
                  'value'=>old('mail_from_address')??\App\Repositories\EmailRepository::fromAddress()])
                </div>
                <div class="col-sm-6">
                  @include('includes.form.input-name', ['id'=>'mail_from_name', 'label'=>__('From Name'),
                  'required'=>true,
                  'value'=>old('mail_from_name')??\App\Repositories\EmailRepository::fromName()])
                </div>
              </div>

              <div class="row d-none" id="mailtrap_area">
                <div class="col-sm-6">
                  @include('includes.form.input', ['id'=>'mail_mailtrap_host', 'label'=>__('SMTP Host'),
                  'required'=>true,
                  'value'=>old('mail_mailtrap_host')??\App\Repositories\EmailRepository::mailtrapHost()])
                </div>
                <div class="col-sm-6">
                  @include('includes.form.input', ['id'=>'mail_port', 'label'=>__('SMTP Port'),
                  'required'=>true,
                  'value'=>old('mail_port')??\App\Repositories\EmailRepository::mailtrapPort()])
                </div>
                <div class="col-sm-6">
                  @include('includes.form.input', ['id'=>'mail_mailtrap_username', 'label'=>__('SMTP Username'),
                  'required'=>true,
                  'value'=>old('mail_mailtrap_username')??\App\Repositories\EmailRepository::mailtrapUsername()])
                </div>
                <div class="col-sm-6">
                  @include('includes.form.input', ['id'=>'mail_mailtrap_password', 'label'=>__('SMTP Password'),
                  'required'=>true,
                  'value'=>old('mail_mailtrap_password')??\App\Repositories\EmailRepository::mailtrapPassword()])
                </div>
                <div class="col-sm-6">
                  @include('includes.form.input', ['id'=>'mail_mailtrap_encryption', 'label'=>__('SMTP Encryption'),
                  'required'=>true,
                  'value'=>old('mail_mailtrap_encryption')??\App\Repositories\EmailRepository::mailtrapEncryption()])
                </div>
              </div>

              <div class="row d-none" id="smtp_area">
                <div class="col-sm-6">
                  @include('includes.form.input', ['id'=>'mail_host', 'label'=>__('SMTP Host'),
                  'required'=>true,
                  'value'=>old('mail_host')??\App\Repositories\EmailRepository::smtpHost()])
                </div>
                <div class="col-sm-6">
                  @include('includes.form.input', ['id'=>'mail_port', 'label'=>__('SMTP Port'),
                  'required'=>true,
                  'value'=>old('mail_port')??\App\Repositories\EmailRepository::smtpPort()])
                </div>
                <div class="col-sm-6">
                  @include('includes.form.input', ['id'=>'mail_username', 'label'=>__('SMTP Username'),
                  'required'=>true,
                  'value'=>old('mail_username')??\App\Repositories\EmailRepository::smtpUsername()])
                </div>
                <div class="col-sm-6">
                  @include('includes.form.input', ['id'=>'mail_password', 'label'=>__('SMTP Password'),
                  'required'=>true,
                  'value'=>old('mail_password')??\App\Repositories\EmailRepository::smtpPassword()])
                </div>
                <div class="col-sm-6">
                  @include('includes.form.input', ['id'=>'mail_encryption', 'label'=>__('SMTP Encryption'),
                  'required'=>true,
                  'value'=>old('mail_encryption')??\App\Repositories\EmailRepository::smtpEncryption()])
                </div>
              </div>

              <div class="row d-none" id="mailgun_area">
                <div class="col-sm-6">
                  @include('includes.form.input', ['id'=>'mail_mailgun_domain', 'label'=>__('Domain'),
                  'required'=>true,
                  'value'=>old('mail_mailgun_domain')??\App\Repositories\EmailRepository::mailgunDomain()])
                </div>
                <div class="col-sm-6">
                  @include('includes.form.input', ['id'=>'mail_mailgun_api_key', 'label'=>__('Api Key / Secret'),
                  'required'=>true,
                  'value'=>old('mail_mailgun_api_key')??\App\Repositories\EmailRepository::mailgunApiKey()])
                </div>
              </div>

              <div class="row">
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
            <h4><i class="fa fa-cogs"></i> {{ __('Pengaturan Lainnya') }}</h4>

          </div>
          <div class="card-body">
            <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
              <input type="hidden" name="type" value="lainnya">
              @method('put')
              @csrf
              <div class="row clearfix">
                <div class="col-sm-6">
                  @include('includes.form.select', ['id'=>'login_must_verified', 'label'=>__('Akun Masuk Verifikasi Email
                  Terlebih Dahulu'),
                  'selected'=>$login_must_verified, 'options'=>['0'=>'Tidak', '1'=>'Ya'], 'required'=>true])
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

@push('scripts')
  <script>
    $(function() {
      $('#mail_provider').on('change', function() {
        $('#smtp_area').addClass('d-none');
        $('#mailtrap_area').addClass('d-none');
        $('#mailgun_area').addClass('d-none');
        $('#' + $(this).val() + '_area').removeClass('d-none');
      });
      $('#{{ $mailProvider }}_area').removeClass('d-none');
    });
  </script>
@endpush
