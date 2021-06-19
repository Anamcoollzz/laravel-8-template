@extends(config('app.template').'.layouts.app')

@section('title')
  Dashboard
@endsection

@if (config('app.template') === 'stisla')
  @section('content')

    <div class="section-header">
      <h1>{{ __('Dashboard') }}</h1>
    </div>
    <div class="row">
      <div class="col-12 mb-4">
        <div class="hero text-white hero-bg-image"
          data-background="{{ \App\Models\Setting::where('key', 'stisla_bg_home')->first()->value }}">
          <div class="hero-inner">
            <h2>{{ __('Selamat Datang') }}, {{ Auth::user()->name ?? 'Your Name' }}</h2>
            <p class="lead">{{ \App\Models\Setting::where('key', 'app_description')->first()->value }}</p>

            @if (auth()->check())
              <div class="mt-4">
                <a href="{{ route('profile.index') }}" class="btn btn-outline-white btn-lg btn-icon icon-left">
                  <i class="far fa-user"></i> {{ __('Lihat Profil') }}
                </a>
              </div>
            @endif

          </div>
        </div>
      </div>

      @foreach (range(1, 4) as $item)
        <div class="col-lg-3 col-md-3 col-sm-6 col-12">
          <div class="card card-statistic-1">
            <div class="card-icon bg-{{ $bg ?? 'primary' }}">
              <i class="fas fa-{{ $ikon ?? 'fire' }}"></i>
            </div>
            <div class="card-wrap">
              <div class="card-header">
                <h4>{{ $judul_widget ?? 'Nama Modul' }}</h4>
              </div>
              <div class="card-body">
                {{ $jumlah_data ?? $loop->iteration . '00' }}
              </div>
            </div>
          </div>
        </div>
      @endforeach


    </div>

  @endsection
@else

  @section('content')

    <div class="container-fluid">
      <div class="block-header">
        <h2>BLANK PAGE</h2>
      </div>

    </div>

  @endsection
@endif
