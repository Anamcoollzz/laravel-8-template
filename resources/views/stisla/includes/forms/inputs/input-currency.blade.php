@php
  $currency_type = $currency_type ?? 'default';
  $isDefault = $currency_type === 'default';
@endphp

@include('stisla.includes.forms.inputs.input', [
    'addClass' => $isDefault ? 'currency' : 'currency_idr',
    'icon' => $icon ?? ($isDefault ? 'fa fa-dollar' : 'fa fa-money-bill-wave'),
])

@if (!defined('CURRENCY'))
  @php
    define('CURRENCY', true);
  @endphp
  @push('css')
  @endpush

  @push('js')
    <script src="{{ asset('js/cleave.min.js') }}"></script>
  @endpush
@endif

@push('scripts')
@endpush
