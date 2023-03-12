<div class="form-group">
  <label for="{{ $id }}">{{ $label ?? 'Summernote Simple' }}
    @if ($required ?? false)
      <span class="text-danger">*</span>
    @endif
  </label>
  <textarea class="{{ $simple ?? false ? 'summernote-simple' : 'summernote' }}" name="{{ $name ?? $id }}" id="{{ $id }}">{{ $value ?? ($d[$name ?? $id] ?? old($name ?? $id)) }}</textarea>
  @if ($errors->has($name ?? $id))
    <div class="text-danger" style="margin-top: -30px;">{{ $errors->first($name ?? $id) }}</div>
  @endif
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
