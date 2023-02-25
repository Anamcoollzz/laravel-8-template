@extends('stisla.layouts.app-table')

@section('title')
  {{ $fullTitle = ($actionType === UPDATE ? __('Ubah') . ' ' : __('Tambah') . ' ') . ($title = 'Data Role') }}
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
      <div class="breadcrumb-item">{{ $actionType === UPDATE ? __('Ubah') . ' ' : __('Tambah') . ' ' }}</div>
    </div>
  </div>

  <div class="section-body">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4><i class="fa fa-lock"></i> {{ $fullTitle }}</h4>
          </div>
          <div class="card-body">
            <form action="{{ $action }}" method="POST">
              @if ($actionType === UPDATE)
                @method('PUT')
              @endif
              @csrf
              <div class="row">
                <div class="col-md-12">
                  @include('stisla.includes.forms.inputs.input-name', ['required' => true, 'disabled' => isset($d), 'icon' => false])
                </div>
                <div class="col-md-12">
                  <h5>Hak akses</h5>
                </div>
                @foreach ($permissionGroups as $group)
                  <div class="col-md-12">
                    <div class="mb-2"><strong>{{ $group->group_name }}</strong></div>
                  </div>
                  @php
                    $i = 0;
                  @endphp
                  <div class="col-md-12 mb-4">
                    <div class="row group-permission">
                      @foreach ($group->permissions as $item)
                        <div class="col-md-3">
                          <label class="colorinput d-flex align-items-center">
                            <div>
                              <input @if ($i === 0) onchange="onChangeFirst(event)" @endif name="permissions[]" value="{{ $item->name }}" type="checkbox" class="colorinput-input"
                                @if (isset($d) && $d->name === 'superadmin') disabled @endif @if (isset($d) && in_array($item->name, $rolePermissions)) checked @endif />
                              <span class="colorinput-color bg-primary"></span>
                            </div>
                            &nbsp;&nbsp;
                            {{ $item->name }}
                          </label>
                        </div>
                        @php
                          $i++;
                        @endphp
                      @endforeach
                    </div>
                  </div>
                @endforeach

                @if (($actionType === UPDATE && $d->name !== 'superadmin') || $actionType === CREATE)
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

@push('scripts')
  <script>
    function onChangeFirst(e) {
      //   alert(e.target.checked);
      $(e.target).parents('.group-permission').find('input').prop('checked', e.target.checked);
    }
  </script>
@endpush
