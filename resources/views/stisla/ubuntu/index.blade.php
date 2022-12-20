@extends('stisla.layouts.app-table')

@section('title')
  Ubuntu
@endsection

@section('content')
  <div class="section-header">
    <h1>{{ __('Ubuntu') }}</h1>
  </div>
  <div class="row">

    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4><i class="fa fa-clock-rotate-left"></i> {{ __('Nginx Sites Available') }}</h4>

        </div>
        <div class="card-body">
          <div class="table-responsive">

            <table class="table table-striped table-hovered" id="datatable">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th class="text-center">{{ __('Filename') }}</th>
                  <th class="text-center">{{ __('Size') }}</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($files as $item)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->filename }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>


  </div>
@endsection

@push('js')
  <script></script>
@endpush
