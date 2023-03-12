@php
  $required = $required ?? false;
@endphp

<div class="form-group">
  <label for="{{ $id }}">{{ $label ?? 'Summernote Simple' }}
    @if ($required)
      <span class="text-danger">*</span>
    @endif
  </label>
  <textarea @if ($required) required @endif class="{{ $simple ?? false ? 'summernote-simple' : 'summernote' }}" name="{{ $name ?? $id }}" id="{{ $id }}">{{ $value ?? ($d[$name ?? $id] ?? old($name ?? $id)) }}</textarea>
  @error($name ?? $id)
    <div id="{{ $id }}-error-feedback" class="invalid-feedback" style="display: block;" for="{{ $id }}">
      {{ $message }}
    </div>
  @enderror
</div>

@if (!defined('SUMMERNOTE'))
  @php
    define('SUMMERNOTE', true);
  @endphp

  @push('js')
    <script src="{{ asset('plugins/summernote/dist/summernote-bs4.js') }}"></script>
  @endpush

  @push('css')
    <link rel="stylesheet" href="{{ asset('plugins/summernote/dist/summernote-bs4.min.css') }}">
  @endpush
@endif
