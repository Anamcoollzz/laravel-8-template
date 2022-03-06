@php
$name = $name ?? $id;
$oldValue = old($name);
$isMultiple = $multiple ?? ($isMultiple ?? false);
$isRequired = $required ?? ($isRequired ?? false);
$selected = $isMultiple ? $oldValue ?? ($selected ?? (is_array($d[$name]) ? $d[$name] : [$d[$name]] ?? [])) : $oldValue ?? ($selected ?? ($d[$name] ?? false));
@endphp

<div class="form-group">
  <label @isset($id) for="{{ $id }}" @endisset>
    {{ $label }}
    @if ($isRequired)
      <span class="text-danger">*</span>
    @endif
  </label>
  <select @if ($isRequired) required @endif @if ($isMultiple) multiple @endif name="{{ $isMultiple ? $name . '[]' : $name }}" id="{{ $id }}"
    class="form-control select2">
    @if ($isMultiple)
      @foreach ($options as $value => $text)
        <option @if (in_array($value, $selected)) selected @endif value="{{ $value }}">{{ $text }}</option>
      @endforeach
    @else
      @foreach ($options as $value => $text)
        <option @if ($selected == $value) selected @endif value="{{ $value }}">{{ $text }}</option>
      @endforeach
    @endif
  </select>
</div>

@if (!defined('SELECT2_IMPORT'))
  @php
    define('SELECT2_IMPORT', true);
  @endphp

  @push('js')
    <script src="{{ asset('stisla/node_modules/select2/dist/js/select2.full.min.js') }}"></script>
  @endpush

  @push('css')
    <link rel="stylesheet" href="{{ asset('stisla/node_modules/select2/dist/css/select2.min.css') }}">
  @endpush

  @push('scripts')
    <script>
      $(function() {

      });
    </script>
  @endpush
@endif
