@extends('stisla.layouts.app')

@section('title')
  {{ isset($d) ? __('Ubah') : __('Tambah') }} {{ $title = 'Jenis Pembayaran' }}
@endsection

@section('content')
  <div class="section-header">
    <h1>{{ $title }}</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active">
        <a href="{{ route('dashboard.index') }}">{{ __('Dashboard') }}</a>
      </div>
      <div class="breadcrumb-item active">
        <a href="{{ route('payment-types.index') }}">{{ __('Jenis Pembayaran') }}</a>
      </div>
      <div class="breadcrumb-item">{{ isset($d) ? __('Ubah') : __('Tambah') }} {{ $title }}</div>
    </div>
  </div>

  <div class="section-body">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4><i class="fa fa-certificate"></i> {{ isset($d) ? __('Ubah') : __('Tambah') }} {{ $title }}</h4>
          </div>
          <div class="card-body">
            <form action="{{ isset($d) ? route('payment-types.update', [$d->id]) : route('payment-types.store') }}"
              method="POST" enctype="multipart/form-data">

              @isset($d)
                @method('PUT')
              @endisset

              @csrf
              <div class="row">
				<div class="col-md-6">
                  @include('stisla.includes.forms.inputs.input', ['required'=>true, 'type'=>'text', 'id'=>'type_name', 'name'=>'type_name', 'label'=>__('Nama Pembayaran')])
                </div>

				<div class="col-md-6">
                  @include('stisla.includes.forms.inputs.input', ['required'=>true, 'type'=>'number', 'id'=>'bill_amount', 'name'=>'bill_amount', 'label'=>__('Tagihan'), 'min'=>0])
                </div>

				<div class="col-md-6">
                  @include('stisla.includes.forms.selects.select', ['required'=>true, 'id'=>'payment_time_type', 'name'=>'payment_time_type', 'label'=>__('Jenis Waktu Pembayaran'), 'options'=>["bulanan","tahunan","sekali"]])
                </div>


                <div class="col-md-12">
                  <br>
                  @include('stisla.includes.forms.buttons.btn-save')
                  @include('stisla.includes.forms.buttons.btn-reset')
                </div>
              </div>
            </form>
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
