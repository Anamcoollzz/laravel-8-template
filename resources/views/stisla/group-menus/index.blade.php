@php
  $isYajra = $isYajra ?? false;
@endphp

@extends('stisla.layouts.app-table')

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

        <div class="card">
          <div class="card-header">
            <h4><i class="{{ $moduleIcon }}"></i> Data {{ $title }}</h4>

            <div class="card-header-action">
              @if ($canCreate)
                @include('stisla.includes.forms.buttons.btn-add', ['link' => $route_create])
              @endif
            </div>
          </div>
          <div class="card-body">
            @include('stisla.includes.forms.buttons.btn-datatable')
            <div class="table-responsive">
              @include('stisla.group-menus.table')
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
@endpush

@push('modals')
@endpush
