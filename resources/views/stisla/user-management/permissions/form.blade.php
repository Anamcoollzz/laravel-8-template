@extends('stisla.layouts.app-table')

@section('title')
  {{ $fullTitle }}
@endsection

@section('content')
  <div class="section-header">
    <h1>{{ $title }}</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active">
        <a href="{{ route('dashboard.index') }}">{{ __('Dashboard') }}</a>
      </div>
      <div class="breadcrumb-item active">
        <a href="{{ $routeIndex }}">{{ $title }}</a>
      </div>
      <div class="breadcrumb-item">{{ $actionType === UPDATE ? __('Ubah') . ' ' : __('Tambah') . ' ' }}</div>
    </div>
  </div>

  <div class="section-body">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4><i class="{{ $moduleIcon }}"></i> {{ $fullTitle }}</h4>
            @can('Permission')
              <div class="card-header-action">
                @include('stisla.includes.forms.buttons.btn-view', ['link' => $routeIndex])
              </div>
            @endcan
          </div>
          <div class="card-body">
            <form action="{{ $action }}" method="POST">
              @if ($actionType === UPDATE)
                @method('PUT')
              @endif
              @csrf
              <div class="row">
                <div class="col-md-6">
                  @include('stisla.includes.forms.inputs.input-name', ['required' => true, 'icon' => false])
                </div>
                <div class="col-md-6">
                  @include('stisla.includes.forms.selects.select', [
                      'id' => 'permission_group_id',
                      'name' => 'permission_group_id',
                      'options' => $groupOptions,
                      'label' => 'Group',
                      'required' => true,
                  ])
                </div>

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
