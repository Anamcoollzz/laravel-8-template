@extends('stisla.layouts.app-crud-generator')

@section('title')
  {{ $title = 'CRUD Generator' }}
@endsection

@section('content')
  <div class="section-header">
    <h1>{{ $title }}</h1>
  </div>

  <div class="section-body">
    <div id="hehehehehehehhe">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h4>CRUD Generator</h4>
            </div>
            <div class="card-body">
              <crud-generator />
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
  <script src="{{ asset('js/crud-generator.min.js?id=1') }}"></script>
@endpush
