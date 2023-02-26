@extends('stisla.layouts.app-table')

@section('title')
  {{ $title }}
@endsection

@section('content')
  @include('stisla.includes.breadcrumbs.breadcrumb-table')

  <div class="section-body">
    <h2 class="section-title">{{ $title }}</h2>
    <p class="section-lead">{{ __('Merupakan data permission diperbolehkan mengakses sistem') }}.</p>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4><i class="{{ $moduleIcon }}"></i> Data {{ $title }}</h4>

            <div class="card-header-action">
              @if ($canImportExcel)
                @include('stisla.includes.forms.buttons.btn-import-excel')
              @endif

              @if ($canCreate)
                @include('stisla.includes.forms.buttons.btn-add', ['link' => $routeCreate])
              @endif
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              @include('stisla.user-management.permissions.table')
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
@endsection

@if ($canImportExcel)
  @push('modals')
    @include('stisla.includes.modals.modal-import-excel', [
        'formAction' => $routeImportExcel,
        'downloadLink' => $routeImportExcelExample,
        'note' => __('Pastikan nama permission tidak ada yang sama'),
    ])
  @endpush
@endif
