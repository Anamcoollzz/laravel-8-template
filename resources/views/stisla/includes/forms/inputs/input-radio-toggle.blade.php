@php
  $value = old($name ?? $id) ?? ($value ?? ($d[$name ?? $id] ?? ''));
  $name = $name ?? $id;
@endphp
<div class="form-group">
  <div class="control-label">{{ $label ?? Str::random(5) }}
    @if ($required ?? false)
      <span class="text-danger">*</span>
    @endif
  </div>
  <div class="custom-switches-stacked mt-2">
    @foreach ($options as $opValue => $opLabel)
      <label class="custom-switch">
        <input @if ($value == $opValue) checked @endif type="radio" name="{{ $name }}" value="{{ $opValue }}" class="custom-switch-input"
          id="{{ $id }}{{ $loop->iteration }}">
        <span class="custom-switch-indicator"></span>
        <span class="custom-switch-description">{{ $opLabel }}</span>
      </label>
    @endforeach
  </div>
  @error($name)
    <div id="{{ $id }}-error-feedback" class="text-danger" for="{{ $id }}">
      {{ $message }}
    </div>
  @enderror
</div>
