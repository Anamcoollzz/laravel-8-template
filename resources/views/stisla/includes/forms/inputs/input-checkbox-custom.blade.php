@php
  $value = old($name ?? $id) ?? ($value ?? ($d[$name ?? $id] ?? []));
  $name = $name ?? $id;
  $required = $required ?? false;
@endphp
<div class="form-group" data-required="{{ $required }}">
  <label class="form-label">
    {{ $label ?? Str::random(5) }}
    @if ($required)
      <span class="text-danger">*</span>
    @endif
  </label>
  <div class="selectgroup selectgroup-pills">
    @foreach ($options as $opValue => $opLabel)
      <label class="selectgroup-item">
        <input type="checkbox" name="{{ $name }}[]" value="{{ $opValue }}" class="selectgroup-input" @if (in_array($opValue, $value)) checked @endif
          id="{{ $id }}{{ $loop->iteration }}">
        <span class="selectgroup-button">{{ $opLabel }}</span>
      </label>
    @endforeach
  </div>
  @error($name)
    <div id="{{ $id }}-error-feedback" class="invalid-feedback" style="display: block;" for="{{ $id }}">
      {{ $message }}
    </div>
  @enderror
</div>
