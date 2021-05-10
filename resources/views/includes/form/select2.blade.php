<div class="form-group">
  <label @isset($id) for="{{ $id }}" @endisset>
    {{ $label }}
    @if ($required ?? false) <span class="text-danger">*</span> @endif
  </label>
  <select @if ($multiple ?? false) multiple @endif
    name="{{ $name ?? $id }}" @isset($id) id="{{ $id }}" @endisset class="form-control
      @if ($multiple ?? false) select2multiple @else select2 @endif">
    @foreach ($options as $value => $text)
      <option @if ($selected ?? false === $value) selected @endif
        value="{{ $value }}">{{ $text }}</option>
    @endforeach
  </select>
</div>

@if (!defined('SELECT2_MULTIPLE'))
  @php
    define('SELECT2_MULTIPLE', true);
  @endphp
  @push('scripts')
    <script>
      $(function() {
        $('.select2multiple').select2({
          // tags: true
          // multiple: true
        });
      });

    </script>
  @endpush
@endif
