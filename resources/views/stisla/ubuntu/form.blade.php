@extends('stisla.layouts.app')

@section('title')
  {{ $fullTitle }}
@endsection

@section('content')
  <div class="section-header">
    <h1>{{ $title }}</h1>
    @include('stisla.includes.breadcrumbs.breadcrumb', [
        'breadcrumbs' => [['label' => __('Dashboard'), 'link' => route('dashboard.index')], ['label' => $title, 'link' => $routeIndex], ['label' => $fullTitle]],
    ])
  </div>


  <div class="section-body">
    <h2 class="section-title">{{ $fullTitle }}</h2>
    <p class="section-lead">{{ __('Menampilkan halaman ' . $fullTitle) }}.</p>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4><i class="fab fa-ubuntu"></i> {{ $fullTitle }}</h4>
            <div class="card-header-action">
              @include('stisla.includes.forms.buttons.btn-view', ['link' => route('ubuntu.index')])
            </div>
          </div>
          <div class="card-body">
            <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
              @method('PUT')

              @csrf
              <div class="row">
                <div class="col-md-6">
                  @include('stisla.includes.forms.inputs.input', ['required' => true, 'name' => 'pathname', 'label' => 'Rename', 'value' => $pathname])
                </div>
                <div class="col-md-12">
                  @include('stisla.includes.forms.editors.textarea', ['required' => true, 'id' => 'filename', 'label' => $pathname, 'value' => old('file', $file)])
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
