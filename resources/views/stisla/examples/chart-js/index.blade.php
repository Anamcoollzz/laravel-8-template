@extends('stisla.layouts.app')

@section('title')
  {{ $title = 'Chart JS' }}
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
    <h2 class="section-title">Chart.js</h2>
    <p class="section-lead">
      We use 'Chart.JS' made by @chartjs. You can check the full documentation <a href="http://www.chartjs.org/">here</a>.
    </p>

    <div class="row">
      <div class="col-12 col-md-6 col-lg-6">
        <div class="card">
          <div class="card-header">
            <h4>Line Chart</h4>
          </div>
          <div class="card-body">
            <canvas id="myChart"></canvas>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-6 col-lg-6">
        <div class="card">
          <div class="card-header">
            <h4>Bar Chart</h4>
          </div>
          <div class="card-body">
            <canvas id="myChart2"></canvas>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12 col-md-6 col-lg-6">
        <div class="card">
          <div class="card-header">
            <h4>Doughnut Chart</h4>
          </div>
          <div class="card-body">
            <canvas id="myChart3"></canvas>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-6 col-lg-6">
        <div class="card">
          <div class="card-header">
            <h4>Pie Chart</h4>
          </div>
          <div class="card-body">
            <canvas id="myChart4"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection


@push('css')
@endpush

@push('js')
  <script src="{{ asset('stisla/node_modules/chart.js/dist/Chart.min.js') }}"></script>
  <script src="{{ asset('stisla/assets/js/page/modules-chartjs.js') }}"></script>
@endpush
