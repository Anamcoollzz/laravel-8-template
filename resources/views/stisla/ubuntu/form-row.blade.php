@extends('stisla.layouts.app')

@section('title')
  {{ $fullTitle }}
@endsection

@section('content')
  <div class="section-header">
    <h1>{{ $title }}</h1>
    @include('stisla.includes.breadcrumbs.breadcrumb', [
        'breadcrumbs' => [
            ['label' => __('Dashboard'), 'link' => route('dashboard.index')],
            ['label' => 'Ubuntu', 'link' => $routeIndex],
            ['label' => $fullTitle, 'link' => $routeIndex],
            ['label' => request('database'), 'link' => route('ubuntu.index', ['database' => request('database')])],
            ['label' => request('table'), 'link' => route('ubuntu.index', ['database' => request('database'), 'table' => request('table')])],
            ['label' => 'Ubah'],
        ],
    ])
  </div>


  <div class="section-body">
    <h2 class="section-title">{{ $fullTitle }}</h2>
    <p class="section-lead">{{ __('Menampilkan halaman ' . $fullTitle) }}.</p>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4><i class="fa fa-database"></i> {{ $fullTitle }}</h4>
            <div class="card-header-action">
              @include('stisla.includes.forms.buttons.btn-view', ['link' => route('ubuntu.index')])
            </div>
          </div>
          <div class="card-body">
            <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
              @method('PUT')

              @csrf
              <div class="row">

                @foreach ($keys as $key)
                  @if ($key === 'id')
                  @else
                    <div class="col-md-6">
                      @include('stisla.includes.forms.inputs.input', ['required' => false, 'name' => $key, 'label' => $key, 'value' => $d[$key]])
                    </div>
                  @endif
                @endforeach

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

@push('js')
  <script src="{{ asset('stisla/node_modules/codemirror/lib/codemirror.js') }}"></script>
  <script src="{{ asset('stisla/node_modules/codemirror/mode/javascript/javascript.js') }}"></script>
@endpush

@push('css')
  <link rel="stylesheet" href="{{ asset('stisla/node_modules/codemirror/lib/codemirror.css') }}">
  <link rel="stylesheet" href="{{ asset('stisla/node_modules/codemirror/theme/duotone-dark.css') }}">
@endpush

@push('scripts')
  <script>
    if (window.CodeMirror) {
      $("#filename").each(function() {
        let editor = CodeMirror.fromTextArea(this, {
          lineNumbers: true,
          theme: "duotone-dark",
          mode: 'javascript',
          height: 500
        });
        editor.setSize("100%", 500);
      });
    }
  </script>
@endpush
