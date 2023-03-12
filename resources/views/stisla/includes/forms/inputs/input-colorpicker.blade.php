@php
  $props = [];
  $id = $id ?? Str::random(5);
  array_push($props, 'id="' . $id . '"');
  array_push($props, 'name="' . ($name ?? $id) . '"');
  array_push($props, 'value="' . (old($name ?? $id) ?? ($value ?? ($d[$name ?? $id] ?? ''))) . '"');
  array_push($props, isset($placeholder) ? 'placeholder="' . $placeholder . '"' : '');
  array_push($props, isset($accept) ? 'accept="' . $accept . '"' : '');
  array_push($props, isset($min) ? 'min="' . $min . '"' : '');
  array_push($props, isset($max) ? 'max="' . $max . '"' : '');
  array_push($props, isset($disabled) ? 'disabled' : '');
  array_push($props, isset($readonly) ? 'readonly' : '');
  array_push($props, $required ?? false ? 'required' : '');
  array_push($props, isset($type) ? 'type="' . $type . '"' : 'type="text"');
@endphp

<div class="form-group">
  <label for="{{ $id ?? $name }}">{{ $label ?? $id }}
    @if ($required ?? false)
      <span class="text-danger">*</span>
    @endif
  </label>
  <div class="input-group colorpickerinput">
    <input {!! implode(' ', $props) !!} class="form-control {{ $errors->has($name ?? $id) ? 'is-invalid' : '' }}">
    <div class="input-group-append">
      <div class="input-group-text">
        <i class="fas fa-fill-drip"></i>
      </div>
    </div>
  </div>
  @error($name ?? $id)
    <div id="{{ $name ?? $id }}-error-feedback" class="text-danger" for="{{ $name ?? $id }}">
      {{ $message }}
    </div>
  @enderror
</div>

@if (!defined('COLORPICKER_IMPORT'))
  @php
    define('COLORPICKER_IMPORT', true);
  @endphp
  @push('css')
    <link rel="stylesheet" href="{{ asset('stisla/node_modules/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
  @endpush

  @push('js')
    <script src="{{ asset('stisla/node_modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}"></script>
  @endpush

  @push('scripts')
  @endpush
@endif
