@extends('stisla.layouts.app-table')

@section('title')
  {{ __('Ubah') }} {{ $title = 'Data Role' }}
@endsection

@section('content')
  <div class="section-header">
    <h1>{{ $title }}</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active">
        <a href="{{ route('dashboard.index') }}">{{ __('Dashboard') }}</a>
      </div>
      <div class="breadcrumb-item active">
        <a href="{{ route('user-management.roles.index') }}">{{ __('Role') }}</a>
      </div>
      <div class="breadcrumb-item">{{ __('Ubah') }} {{ $title }}</div>
    </div>
  </div>

  <div class="section-body">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4><i class="fa fa-users"></i> {{ __('Ubah') }} {{ $title }}</h4>
          </div>
          <div class="card-body">
            <form action="{{ route('user-management.roles.update', [$d->id]) }}" method="POST">
              @method('PUT')
              @csrf
              <div class="row">
                <div class="col-md-12">
                  @include('stisla.includes.forms.inputs.input-name',['required'=>true, 'disabled'=>true, 'icon'=>false])
                </div>
                <div class="col-md-12">
                  <h5>Hak akses</h5>
                </div>
                @foreach ($permissions as $item)
                  <div class="col-md-3">
                    <label class="colorinput d-flex align-items-center">
                      <div>
                        <input name="permissions[]" value="{{ $item->name }}" type="checkbox" class="colorinput-input"
                          @if ($d->name === 'superadmin') disabled @endif @if (in_array($item->name, $rolePermissions)) checked @endif />
                        <span class="colorinput-color bg-primary"></span>
                      </div>
                      &nbsp;&nbsp;
                      {{ $item->name }}
                    </label>
                  </div>
                @endforeach

                @if ($d->name !== 'superadmin')
                  <div class="col-md-12">
                    <br>
                    @include('stisla.includes.forms.buttons.btn-save')
                    @include('stisla.includes.forms.buttons.btn-reset')
                  </div>
                @endif
              </div>
            </form>
          </div>
        </div>
      </div>

    </div>
  </div>
@endsection
