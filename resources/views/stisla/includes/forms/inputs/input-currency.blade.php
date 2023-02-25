@include('stisla.includes.forms.inputs.input', ['addClass' => 'currency', 'icon' => $icon ?? ($currency_type === 'default' ? 'fa fa-dollar' : 'fa fa-money-bill-wave')])

@if (!defined('CURRENCY'))
  @php
    define('CURRENCY', true);
  @endphp
  @push('css')
    {{-- <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}"> --}}
  @endpush

  @push('js')
    <script src="{{ asset('js/cleave.min.js') }}"></script>
  @endpush
@endif

@push('scripts')
  @if (($currency_type ?? 'default') === 'default')
    <script>
      $(function() {
        var cleaveC = new Cleave('.currency', {
          numeral: true,
          numeralThousandsGroupStyle: 'thousand'
        });

      })
    </script>
  @else
    <script>
      $(function() {
        var cleaveC = new Cleave('#{{ $id }}', {
          numeral: true,
          numeralDecimalMark: ',',
          delimiter: '.'
        });
      })
    </script>
  @endif
@endpush
