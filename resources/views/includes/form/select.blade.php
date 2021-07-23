<div class="form-group">
  <label @isset($id) for="{{ $id }}" @endisset>
    {{ $label }}
    @if ($required ?? false) <span class="text-danger">*</span> @endif
  </label>
  <select @if ($multiple ?? false) multiple @endif
    name="{{ $name ?? ($multiple ?? false ? $id . '[]' : $id) }}" @isset($id) id="{{ $id }}" @endisset
    class="form-control {{ $select2 ?? false ? 'select2' : '' }}">
    @foreach ($options as $value => $text)
      <option @if (($selected ?? ($d[$name ?? $id] ?? false)) == $value) selected @endif value="{{ $value }}">{{ $text }}</option>
    @endforeach
  </select>
</div>
