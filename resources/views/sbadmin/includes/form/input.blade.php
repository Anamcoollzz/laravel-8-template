@php
$props = [];
$id = $id ?? Str::random(5);
array_push($props, 'id="' . $id . '"');
array_push($props, 'name="' . ($name ?? $id) . '"');
array_push($props, 'value="' . (old($name ?? $id) ?? ($value ?? ($d[$name ?? $id] ?? ''))) . '"');
array_push($props, isset($placeholder) ? 'placeholder="' . $placeholder . '"' : '');
array_push($props, isset($accept) ? 'accept="' . $accept . '"' : '');
array_push($props, isset($min) ? 'min="' . $min . '"' : '');
array_push($props, isset($max) ? 'max="' . $max . '"' : '');
array_push($props, isset($disabled) ? 'disabled' : '');
array_push($props, isset($readonly) ? 'readonly' : '');
array_push($props, $required ?? false ? 'required' : '');
array_push($props, isset($type) ? 'type="' . $type . '"' : 'type="text"');
@endphp

@if (config('app.template') === 'stisla')
  @if ($icon ?? false)
    <div class="form-group">
      <label for="{{ $id ?? $name }}"
        class="{{ $errors->has($name ?? $id) ? 'text-danger' : '' }}">{{ $label ?? $id }}
        @if ($required ?? false)
          <span class="text-danger">*</span>
        @endif
      </label>
      <div class="input-group">
        <div class="input-group-prepend">
          <div class="input-group-text {{ $errors->has($name ?? $id) ? 'border-danger' : '' }}">
            <i class="{{ $icon }}"></i>
          </div>
        </div>
        <input {!! implode(' ', $props) !!} class="form-control {{ $errors->has($name ?? $id) ? 'is-invalid' : '' }}">
      </div>
      @if ($hint ?? false)
        <div class="text-muted">{{ $hint }}</div>
      @endif
      @error($name ?? $id)
        <div id="{{ $name ?? $id }}-error-feedback" class="text-danger" for="{{ $name ?? $id }}">
          {{ $message }}
        </div>
      @enderror
    </div>
  @else
    <div class="form-group">
      <label for="{{ $id ?? $name }}"
        class="{{ $errors->has($name ?? $id) ? 'text-danger' : '' }}">{{ $label ?? $id }}
        @if ($required ?? false)
          <span class="text-danger">*</span>
        @endif
      </label>
      <input {!! implode(' ', $props) !!} class="form-control {{ $errors->has($name ?? $id) ? 'is-invalid' : '' }}">
      @if ($hint ?? false)
        <div class="text-muted">{{ $hint }}</div>
      @endif

      @error($name ?? $id)
        <div id="{{ $name ?? $id }}-error-feedback" class="invalid-feedback" for="{{ $name ?? $id }}">
          {{ $message }}
        </div>
      @enderror
    </div>
  @endif

@else
  <div class="form-group form-float">
    <div class="form-line  @error($name ?? $id) error @enderror">
      <input {!! implode(' ', $props) !!} class="form-control">
      <label class="form-label">{{ $label ?? $id }}</label>
    </div>

    @if ($hint ?? false)
      <div class="help-info">{{ $hint }}</div>
    @endif

    @error($name ?? $id)
      <label id="{{ $name ?? $id }}-error-feedback" class="error"
        for="{{ $name ?? $id }}">{{ $message }}</label>
    @enderror
  </div>

@endif
