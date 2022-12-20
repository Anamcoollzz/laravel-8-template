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
          <h4><i class="fa fa-ubuntu"></i> {{ __('Nginx Sites Available') }}</h4>

        </div>
        <div class="card-body">
          <div class="table-responsive">

            <table class="table table-striped table-hovered" id="datatable">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th class="text-center">{{ __('Filename') }}</th>
                  <th class="text-center">{{ __('Enabled') }}</th>
                  <th class="text-center">{{ __('Aksi') }}</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($files as $item)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->getFilename() }}</td>
                    <td>
                      @if ($item->enabled)
                        <a href="{{ route('ubuntu.toggle-enabled', [encrypt($item->getPathname()), 'false']) }}" class="btn btn-sm btn-success">true</a>
                      @else
                        <a href="{{ route('ubuntu.toggle-enabled', [encrypt($item->getPathname()), 'false']) }}" class="btn btn-sm btn-danger">false</a>
                      @endif
                    </td>
                    <td>
                      @include('stisla.includes.forms.buttons.btn-edit', ['link' => route('ubuntu.edit', [encrypt($item->getPathname())])])
                      @include('stisla.includes.forms.buttons.btn-edit', [
                          'link' => route('ubuntu.duplicate', [encrypt($item->getPathname())]),
                          'icon' => 'fa fa-copy',
                          'tooltip' => 'Duplikasi',
                      ])
                      @include('stisla.includes.forms.buttons.btn-delete', ['link' => route('ubuntu.destroy', [encrypt($item->getPathname())])])
                    </td>
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
