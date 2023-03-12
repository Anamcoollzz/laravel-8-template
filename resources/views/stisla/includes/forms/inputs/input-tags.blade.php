@include('stisla.includes.forms.inputs.input', ['addClass' => 'inputtags'])

@if (!defined('INPUTTAGS'))
  @php
    define('INPUTTAGS', true);
  @endphp
  @push('css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
  @endpush

  @push('js')
    <script src="{{ asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}"></script>
  @endpush

  @push('scripts')
  @endpush
@endif
