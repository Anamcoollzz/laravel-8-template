@extends('stisla.layouts.app-table')

@section('title')
  {{ $title = 'Kelas' }}
@endsection

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
            <h4><i class="fa fa-certificate"></i> Data {{ $title }}</h4>
            <div class="card-header-action">
              {{-- @can('Kelas Impor Excel') --}}
              @include('stisla.includes.forms.buttons.btn-import-excel')
              {{-- @endcan --}}
              {{-- @can('Kelas Tambah') --}}
              @include('stisla.includes.forms.buttons.btn-add', ['link'=>route('views.classes.create')])
              {{-- @endcan --}}
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped" id="datatable">
                <thead>
                  <tr>
                    <th class="text-center">{{ __('#') }}</th>
                    <th class="text-center">{{ __('Jenjang') }}</th>

                    <th>{{ __('Aksi') }}</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>7</td>

                    <td>
                      {{-- @can('Kelas Ubah') --}}
                      @include('stisla.includes.forms.buttons.btn-edit', ['link'=>route('views.classes.edit', [1])])
                      {{-- @can('Kelas Hapus') --}}
                      @include('stisla.includes.forms.buttons.btn-delete')
                      {{-- @endcan --}}
                    </td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td>8</td>

                    <td>
                      {{-- @can('Kelas Ubah') --}}
                      @include('stisla.includes.forms.buttons.btn-edit', ['link'=>route('views.classes.edit', [1])])
                      {{-- @can('Kelas Hapus') --}}
                      @include('stisla.includes.forms.buttons.btn-delete')
                      {{-- @endcan --}}
                    </td>
                  </tr>
                  <tr>
                    <td>3</td>
                    <td>9</td>

                    <td>
                      {{-- @can('Kelas Ubah') --}}
                      @include('stisla.includes.forms.buttons.btn-edit', ['link'=>route('views.classes.edit', [1])])
                      {{-- @can('Kelas Hapus') --}}
                      @include('stisla.includes.forms.buttons.btn-delete')
                      {{-- @endcan --}}
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
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

@push('scripts')
  <script>

  </script>
@endpush

@push('modals')
  @include('stisla.includes.modals.modal-import-excel', ['formAction'=>route('payment-types.import-excel'),
  'downloadLink'=>route('payment-types.import-excel-example')])
@endpush
