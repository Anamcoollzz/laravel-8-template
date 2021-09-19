@extends($data->count() > 0 ? 'stisla.layouts.app-table' : 'stisla.layouts.app')

@section('title')
  {{ $title = 'Contoh CRUD' }}
@endsection

@section('content')
  @include('stisla.includes.breadcrumbs.breadcrumb-table')

  <div class="section-body">
    <h2 class="section-title">{{ $title }}</h2>
    <p class="section-lead">{{ __('Menampilkan halaman ' . $title) }}.</p>
    <div class="row">
      <div class="col-12">
        @if ($data->count() > 0)
          <div class="card">
            <div class="card-header">
              <h4><i class="fa fa-atom"></i> Data {{ $title }}</h4>

              <div class="card-header-action">
                {{-- @can('Contoh CRUD Impor Excel') --}}
                @include('stisla.includes.forms.buttons.btn-import-excel')
                {{-- @endcan --}}
                {{-- @can('Contoh CRUD Tambah') --}}
                @include('stisla.includes.forms.buttons.btn-add', ['link'=>route('crud-examples.create')])
                {{-- @endcan --}}
              </div>
            </div>
            <div class="card-body">
              @include('stisla.includes.forms.buttons.btn-datatable')
              <div class="table-responsive">
                @include('stisla.crud-example.export-excel-example', ['isExport'=>false])
              </div>
            </div>
          </div>
        @else
          @include('stisla.includes.others.empty-state', ['title'=>'Data '.$title, 'icon'=>'fa
          fa-atom','link'=>route('crud-examples.create')])
        @endif
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
  @include('stisla.includes.modals.modal-import-excel', ['formAction'=>route('crud-examples.import-excel'),
  'downloadLink'=>route('crud-examples.import-excel-example')])

@endpush
