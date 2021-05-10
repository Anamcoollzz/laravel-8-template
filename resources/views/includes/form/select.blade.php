<div class="form-group">
  <label @isset($id) for="{{ $id }}" @endisset>
    {{ $label }}
    @if ($required ?? false) <span class="text-danger">*</span> @endif
  </label>
  <select @if ($multiple ?? false) multiple @endif
    name="{{ $name ?? $id }}" @isset($id) id="{{ $id }}" @endisset class="form-control">
    @foreach ($options as $value => $text)
      <option @if (($selected ?? false) == $value) selected @endif
        value="{{ $value }}">{{ $text }}</option>
    @endforeach
  </select>
</div>
