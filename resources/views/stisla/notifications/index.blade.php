@extends('stisla.layouts.app')

@section('title')
  {{ $title }}
@endsection

@section('content')
  <div class="section-header">
    <h1> <i class="fa fa-bell-o"></i> {{ $title }}</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active">
        <a href="{{ route('dashboard.index') }}">{{ __('Dashboard') }}</a>
      </div>
      <div class="breadcrumb-item">{{ $title }}</div>
    </div>
  </div>

  <div class="section-body">

    <h2 class="section-title">{{ $title }}</h2>
    <p class="section-lead">{{ __('Merupakan halaman yang menampilkan kumpulan data ' . $title) }}.</p>

    <div class="row">

      <div class="col-12">
        <div class="activities">
          @foreach ($data as $d)
            <div class="activity">
              <div class="activity-icon bg-{{ $d->bg_color ?? 'primary' }} text-white shadow-{{ $d->bg_color ?? 'primary' }}">
                <i class="fas fa-{{ $d->icon ?? 'bell' }}"></i>
              </div>
              <div class="activity-detail">
                <div class="mb-2">
                  <span class="text-job text-primary">
                    {{ time_since($d->created_at) }}
                    @if ($d->is_read)
                      <i class="fa fa-check"></i>
                    @endif
                  </span>
                  {{-- <div class="float-right dropdown">
                    <a href="#" data-toggle="dropdown"><i class="fas fa-ellipsis-h"></i></a>
                    <div class="dropdown-menu">
                      <div class="dropdown-title">Opsi</div>
                      @if (is_null($d->is_read))
                        <a href="{{ route('notifications.read', [$d->id]) }}" class="dropdown-item has-icon"><i class="fas fa-eye"></i> Sudah Dibaca</a>
                      @else
                        <a href="{{ route('notifications.set', ['belum_dibaca', $d->id]) }}" class="dropdown-item has-icon"><i class="fas fa-list"></i> Belum Dibaca</a>
                      @endif
                    </div>
                  </div> --}}
                </div>
                <p>
                  {{ $d->content }}
                </p>
                <div>
                  @if ($d->is_read == 0)
                    <a href="{{ route('notifications.read', [$d->id]) }}" class="btn btn-primary btn-sm icon"><i class="fa fa-check"></i> Tandai Sudah Dibaca</a>
                  @endif
                </div>
              </div>
            </div>
          @endforeach
        </div>

        @if ($data->count() > 0)
          <div class="card">
            <div class="card-body">
              @if ($countUnRead > 0)
                <div class="@if ($data->hasPages()) mb-4 @endif">
                  <a href="{{ route('notifications.read-all') }}" class="btn btn-success icon"><i class="fa fa-check"></i> Tandai Semua Sudah Dibaca</a>
                </div>
              @endif
              {{ $data->links('pagination::bootstrap-4') }}
            </div>
          </div>
        @endif
      </div>

      @if ($data->count() === 0)
        <div class="col-12">
          @include('stisla.includes.others.empty-state', ['icon' => 'fa fa-bell', 'emptyDesc' => 'Tidak ada notifikasi yang bisa ditampilkan'])
        </div>
      @endif
    </div>
  </div>
@endsection
