@php
$props = [];
$id = $id ?? Str::random(5);
array_push($props, 'id="' . $id . '"');
array_push($props, 'name="' . ($name ?? $id) . '"');
array_push($props, 'value="' . (old($name ?? $id) ?? ($d->name ?? ($d->$id ?? ($value ?? '')))) . '"');
array_push($props, isset($placeholder) ? 'placeholder="' . $placeholder . '"' : '');
array_push($props, isset($accept) ? 'accept="' . $accept . '"' : '');
array_push($props, isset($min) ? 'min="' . $min . '"' : '');
array_push($props, isset($max) ? 'max="' . $max . '"' : '');
array_push($props, isset($disabled) ? 'disabled' : '');
array_push($props, isset($readonly) ? 'readonly' : '');
array_push($props, isset($required) ? 'required' : '');
array_push($props, isset($type) ? 'type="' . $type . '"' : 'type="text"');
@endphp

<div class="form-group form-float">
  <div class="form-line  @error($name ?? $id) error @enderror">
    <input {!! implode(' ', $props) !!} class="form-control">
    <label class="form-label">{{ $label ?? $id }}</label>
  </div>

  @if ($hint ?? false)
    <div class="help-info">{{ $hint }}</div>
  @endif

  @error($name ?? $id)
    <label id="{{ $name ?? $id }}-error" class="error" for="{{ $name ?? $id }}">{{ $message }}</label>
  @enderror
</div>
