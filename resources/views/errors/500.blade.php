@extends('stisla.layouts.app-blank', \App\Repositories\SettingRepository::settings())

@section('content')
  @if (config('app.template') === 'stisla')
    @include('errors.default-stisla', ['code' => 500, 'description' => __('Server Error, Silakan Hubungi Developer')])
  @endif
@endsection

@section('title')
  500 {{ __('Server Error') }}
@endsection
