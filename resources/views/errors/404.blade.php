@extends('stisla.layouts.app-blank', \App\Repositories\SettingRepository::settings())

@section('content')
  @if (config('app.template') === 'stisla')
    @include('errors.default-stisla', ['code'=>404, 'description'=>__('Halaman yang anda tuju tidak ada')])
  @endif
@endsection

@section('title')
  404 {{ __('Halaman yang anda tuju tidak ada') }}
@endsection
