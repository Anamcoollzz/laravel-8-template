@php
  $isYajra = $isYajra ?? false;
@endphp

@extends($data->count() > 0 || $isYajra ? 'stisla.layouts.app-table' : 'stisla.layouts.app')

@section('title')
  {{ $title }}
@endsection

@section('content')
  @include('stisla.includes.breadcrumbs.breadcrumb-table')

  <div class="section-body">
    <h2 class="section-title">{{ $title }}</h2>
    <p class="section-lead">{{ __('Menampilkan halaman ' . $title) }}.</p>
    <div class="row">
      <div class="col-12">
        @if ($data->count() > 0 || $isYajra)
          @if ($canExport)
            <div class="card">
              <div class="card-header">
                <h4><i class="{{ $moduleIcon }}"></i> {!! __('Aksi Ekspor <small>(Server Side)</small>') !!}</h4>
                <div class="card-header-action">
                  @include('stisla.includes.forms.buttons.btn-pdf-download', ['link' => $routePdf])
                  @include('stisla.includes.forms.buttons.btn-excel-download', ['link' => $routeExcel])
                  @include('stisla.includes.forms.buttons.btn-csv-download', ['link' => $routeCsv])
                  @include('stisla.includes.forms.buttons.btn-json-download', ['link' => $routeJson])
                </div>
              </div>
            </div>
          @endif

          <div class="card">
            <div class="card-header">
              <h4><i class="{{ $moduleIcon }}"></i> Data {{ $title }}</h4>

              <div class="card-header-action">
                @if ($canImportExcel)
                  @include('stisla.includes.forms.buttons.btn-import-excel')
                @endif
                @if ($canCreate)
                  @include('stisla.includes.forms.buttons.btn-add', ['link' => $route_create])
                @endif
              </div>
            </div>
            <div class="card-body">
              @include('stisla.includes.forms.buttons.btn-datatable')
              <div class="table-responsive">
                @include('stisla.crud-example.table')
              </div>
            </div>
          </div>
        @else
          @include('stisla.includes.others.empty-state', ['title' => 'Data ' . $title, 'icon' => $moduleIcon, 'link' => $route_create])
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
  @if ($isYajra)
    <script>
      $(function() {
        var table = $('.yajra-datatable').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('yajra-crud-examples.ajax') }}",
          columns: [{
              data: 'DT_RowIndex',
              name: 'DT_RowIndex',
              searchable: false,
              orderable: false
            },
            {
              data: 'text',
              name: 'text'
            },
            {
              data: 'number',
              name: 'number'
            },
            {
              data: 'currency',
              name: 'currency'
            },
            {
              data: 'currency_idr',
              name: 'currency_idr'
            },
            {
              data: 'select',
              name: 'select'
            },
            {
              data: 'select2',
              name: 'select2'
            },
            {
              data: 'select2_multiple',
              name: 'select2_multiple'
            },
            {
              data: 'textarea',
              name: 'textarea'
            },
            {
              data: 'radio',
              name: 'radio'
            },
            {
              data: 'checkbox',
              name: 'checkbox'
            },
            {
              data: 'checkbox2',
              name: 'checkbox2'
            },
            {
              data: 'tags',
              name: 'tags'
            },
            {
              data: 'file',
              name: 'file'
            },
            {
              data: 'date',
              name: 'date'
            },
            {
              data: 'time',
              name: 'time'
            },
            {
              data: 'color',
              name: 'color'
            },
            {
              data: 'created_at',
              name: 'created_at'
            },
            {
              data: 'updated_at',
              name: 'updated_at'
            },
            {
              data: 'action',
              name: 'action',
              orderable: true,
              searchable: true
            },
          ]
        });

      });
    </script>
  @endif
@endpush

@push('modals')
  @if ($canImportExcel)
    @include('stisla.includes.modals.modal-import-excel', [
        'formAction' => $routeImportExcel,
        'downloadLink' => $routeExampleExcel,
    ])
  @endif
@endpush
