@extends('stisla.layouts.app-blank')

@section('content')
  @if (config('app.template') === 'stisla')
    @include('errors.default-stisla', ['code'=>503, 'description'=>__('Service tidak tersedia')])
  @endif
@endsection

@section('title')
  503 {{ __('Service tidak tersedia') }}
@endsection
