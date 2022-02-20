@extends('stisla.layouts.app-table')

@section('title')
  {{ $title = 'Grup Kelas' }}
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
              {{-- @can('Grup Kelas Impor Excel') --}}
              @include('stisla.includes.forms.buttons.btn-import-excel')
              {{-- @endcan --}}
              {{-- @can('Grup Kelas Tambah') --}}
              @include('stisla.includes.forms.buttons.btn-add', ['link'=>route('views.group-classes.create')])
              {{-- @endcan --}}
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped" id="datatable">
                <thead>
                  <tr>
                    <th class="text-center">{{ __('#') }}</th>
                    <th class="text-center">{{ __('Grup') }}</th>

                    <th>{{ __('Aksi') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach (['A', 'B', 'C', 'D', 'E', 'F'] as $item)
                    <tr>
                      <td>1</td>
                      <td>{{ $item }}</td>

                      <td>
                        {{-- @can('Grup Kelas Ubah') --}}
                        @include('stisla.includes.forms.buttons.btn-edit', ['link'=>route('views.group-classes.edit', [1])])
                        {{-- @can('Grup Kelas Hapus') --}}
                        @include('stisla.includes.forms.buttons.btn-delete')
                        {{-- @endcan --}}
                      </td>
                    </tr>
                  @endforeach
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
