@php
$value = old($name ?? $id) ?? ($value ?? ($d[$name ?? $id] ?? ''));
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
        <input @if ($value == $opValue) checked @endif type="radio"
          name="{{ $name ?? $id }}" value="{{ $opValue }}" class="custom-switch-input">
        <span class="custom-switch-indicator"></span>
        <span class="custom-switch-description">{{ $opLabel }}</span>
      </label>
    @endforeach
  </div>
  @error($name ?? $id)
    <div id="{{ $name ?? $id }}-error-feedback" class="text-danger" for="{{ $name ?? $id }}">
      {{ $message }}
    </div>
  @enderror
</div>
