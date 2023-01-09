@extends('stisla.layouts.app')

@section('title')
  {{ $title }}
@endsection

@section('content')

@section('content')
  @include('stisla.includes.breadcrumbs.breadcrumb-table')

  <div class="section-body">

    <h2 class="section-title">{{ $title }}</h2>
    <p class="section-lead">{{ __('Merupakan halaman yang menampilkan ' . $title) }}.</p>

    <div class="row clearfix">
      <div class="col-sm-6">
        <div class="card card-large-icons">
          <div class="card-icon bg-primary text-white">
            <i class="fa fa-folder"></i>
          </div>
          <div class="card-body">
            <h4>WWW Folder</h4>
            <p>{{ $item['desc'] }}</p>
            <a href="" class="card-cta">
              Perbarui
              <i class="fas fa-chevron-right"></i>
            </a>
          </div>
        </div>
      </div>

    </div>
  </div>

@endsection

@push('scripts')
  <script></script>
@endpush
