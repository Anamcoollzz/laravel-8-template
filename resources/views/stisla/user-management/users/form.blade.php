@extends('stisla.layouts.app')

@section('title')
  {{ $action }} {{ $title = 'Data Pengguna' }}
@endsection

@section('content')
  <div class="section-header">
    <h1>{{ $title }}</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active">
        <a href="{{ route('dashboard.index') }}">{{ __('Dashboard') }}</a>
      </div>
      @can('Pengguna')
        <div class="breadcrumb-item active">
          <a href="{{ route('user-management.users.index') }}">{{ __('Data Pengguna') }}</a>
        </div>
      @endcan
      <div class="breadcrumb-item">{{ $action }}</div>
    </div>
  </div>

  <div class="section-body">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4><i class="fa fa-users"></i> {{ $action }} {{ $title }}</h4>
            @can('Pengguna')
              <div class="card-header-action">
                @include('stisla.includes.forms.buttons.btn-view', ['link' => route('user-management.users.index')])
              </div>
            @endcan
          </div>
          <div class="card-body">
            <form action="{{ isset($d) ? route('user-management.users.update', [$d->id]) : route('user-management.users.store') }}" method="POST" id="formAction">

              @isset($d)
                @method('PUT')
              @endisset

              @csrf
              <div class="row">
                <div class="col-md-6">
                  @include('stisla.includes.forms.inputs.input-name', ['required' => true])
                </div>
                <div class="col-md-6">
                  @include('stisla.includes.forms.inputs.input', [
                      'id' => 'phone_number',
                      'name' => 'phone_number',
                      'label' => __('No HP'),
                      'type' => 'text',
                      'required' => false,
                      'icon' => 'fas fa-phone',
                  ])
                </div>
                <div class="col-md-6">
                  @include('stisla.includes.forms.inputs.input', [
                      'id' => 'birth_date',
                      'name' => 'birth_date',
                      'label' => __('Tanggal Lahir'),
                      'type' => 'date',
                      'required' => false,
                      'icon' => 'fas fa-calendar',
                  ])
                </div>
                <div class="col-md-6">
                  @include('stisla.includes.forms.inputs.input', [
                      'id' => 'address',
                      'name' => 'address',
                      'label' => __('Alamat'),
                      'type' => 'text',
                      'required' => false,
                      'icon' => 'fas fa-map-marker-alt',
                  ])
                </div>
                @if (count($roleOptions) > 1)
                  {{-- <div class="col-md-6">
                    @include('stisla.includes.forms.selects.select', ['id' => 'role', 'name' => 'role', 'options' => $roleOptions, 'label' => 'Role', 'required' => true])
                  </div> --}}
                  <div class="col-md-6">
                    @include('stisla.includes.forms.selects.select2', [
                        'id' => 'role',
                        'name' => 'role',
                        'options' => $roleOptions,
                        'label' => __('Pilih Role'),
                        'required' => true,
                        'multiple' => true,
                    ])
                  </div>
                @elseif(count($roleOptions) == 1)
                  <input type="hidden" name="role" value="{{ collect($roleOptions)->first() }}">
                @endif
                <div class="col-md-6">
                  @include('stisla.includes.forms.inputs.input-email')
                </div>
                <div class="col-md-6">
                  @include('stisla.includes.forms.inputs.input-password', [
                      'hint' => isset($d) ? 'Password bisa dikosongi' : false,
                      'required' => !isset($d),
                      'value' => isset($d) ? '' : null,
                  ])
                </div>
                <div class="col-md-12" id="formAreaButton">
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

@push('scripts')
  @include('stisla.includes.scripts.disable-form')
@endpush
