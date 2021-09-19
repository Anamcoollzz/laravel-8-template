<div>
  <label @isset($id) for="{{ $id }}" @endisset>
    {{ $label }}
    @if ($required ?? false) <span class="text-danger">*</span> @endif
  </label>
  <textarea class="summernote" @if ($required ?? false) required @endif
    name="{{ $name ?? $id }}" @isset($id) id="{{ $id }}"
    @endisset>{{ old($name ?? $id, $d->$name ?? ($d->$id ?? '')) }}</textarea>
  @if ($errors->has($name ?? $id))
    <span class="text-danger">{{ $errors->first($name ?? $id) }}</span>
  @endif
</div>

@if (!defined('SUMMERNOTE'))
  @php
    define('SUMMERNOTE', true);
  @endphp
  @push('scripts')
    <script>
      $(function() {
        $('.summernote').summernote({
          height: 300
        });
      })

    </script>
  @endpush
@endif
