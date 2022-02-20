@extends('stisla.layouts.app')

@section('title')
  Dashboard
@endsection

@section('content')
  <div class="section-header">
    <h1>{{ __('Dashboard') }}</h1>
  </div>
  <div class="row">
    <div class="col-12 mb-4">
      <div class="hero text-white hero-bg-image" data-background="{{ $_stisla_bg_home }}">
        <div class="hero-inner">
          <h2>{{ __('Selamat Datang') }}, {{ Auth::user()->name ?? 'Your Name' }}</h2>
          <p class="lead">{{ $_app_description }}</p>

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
  </div>

  <div class="row">
    <div class="col-md-12">
      <h6 class="text-primary">Data Siswa</h6>
    </div>
    @foreach ($widgets as $item)
      <div class="col-lg-3 col-md-3 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-{{ $item['bg'] ?? 'primary' }}">
            <i class="fas fa-{{ $item['icon'] ?? 'fire' }}"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>{{ $item['name'] ?? 'Nama Modul' }}</h4>
            </div>
            <div class="card-body">
              {{ $item['count'] ?? $loop->iteration . '00' }}
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <div class="row">
    <div class="col-md-12">
      <h6 class="text-primary">Data Transaksi</h6>
    </div>
    @foreach ($widgets2 ?? [] as $item)
      <div class="col-lg-3 col-md-3 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-{{ $item['bg'] ?? 'primary' }}">
            <i class="fas fa-{{ $item['icon'] ?? 'fire' }}"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>{{ $item['name'] ?? 'Nama Modul' }}</h4>
            </div>
            <div class="card-body">
              {{ $item['count'] ?? $loop->iteration . '00' }}
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <div class="row">
    <div class="col-md-12">
      <h6 class="text-primary">Data Lainnya</h6>
    </div>
    @foreach ($widgets3 ?? [] as $item)
      <div class="col-lg-3 col-md-3 col-sm-6 col-12">
        <div class="card card-statistic-1">
          <div class="card-icon bg-{{ $item['bg'] ?? 'primary' }}">
            <i class="fas fa-{{ $item['icon'] ?? 'fire' }}"></i>
          </div>
          <div class="card-wrap">
            <div class="card-header">
              <h4>{{ $item['name'] ?? 'Nama Modul' }}</h4>
            </div>
            <div class="card-body">
              {{ $item['count'] ?? $loop->iteration . '00' }}
            </div>
          </div>
        </div>
      </div>
    @endforeach
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4>Penerimaan Pembayaran Hari Ini</h4>
        </div>
        <div class="card-body">
          <table class="table table-bordered table-hovered table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Kelas</th>
                <th>Jumlah</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>7</td>
                <td>Rp50.000</td>
              </tr>
              <tr>
                <td>2</td>
                <td>8</td>
                <td>Rp150.000</td>
              </tr>
              <tr>
                <td>3</td>
                <td>9</td>
                <td>Rp250.000</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      <div class="card">
        <div class="card-header">
          <h4>Progress Pembayaran Tahun Ajaran 2021/2022</h4>
        </div>
        <div class="card-body">
          <table class="table table-bordered table-hovered table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Kelas</th>
                <th>Laki-laki</th>
                <th>Perempuan</th>
                <th>Tanggungan</th>
                <th>Terbayar</th>
                <th>Kurang</th>
                <th>Progress</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>7</td>
                <td>300</td>
                <td>200</td>
                <td>Rp250.000.000</td>
                <td>Rp150.000.000</td>
                <td>Rp100.000.000</td>
                <td>60%</td>
              </tr>
              <tr>
                <td>2</td>
                <td>8</td>
                <td>300</td>
                <td>200</td>
                <td>Rp250.000.000</td>
                <td>Rp150.000.000</td>
                <td>Rp100.000.000</td>
                <td>60%</td>
              </tr>
              <tr>
                <td>3</td>
                <td>9</td>
                <td>300</td>
                <td>200</td>
                <td>Rp250.000.000</td>
                <td>Rp150.000.000</td>
                <td>Rp100.000.000</td>
                <td>60%</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection
