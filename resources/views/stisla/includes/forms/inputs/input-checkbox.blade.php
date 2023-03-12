@php
  $value = old($name ?? $id) ?? ($value ?? ($d[$name ?? $id] ?? []));
  $name = $name ?? $id;
  $required = $required ?? false;
@endphp
<div class="form-group" data-required="{{ $required }}">
  <label class="form-label">
    {{ $label ?? Str::random(5) }}
    @if ($required ?? false)
      <span class="text-danger">*</span>
    @endif
  </label>
  @foreach ($options as $opValue => $opLabel)
    <div class="row gutters-xs">
      <div class="col-auto">
        <label class="colorinput">
          <input id="{{ $id }}{{ $loop->iteration }}" name="{{ $name ?? $id }}[]" type="checkbox" value="{{ $opLabel }}" class="colorinput-input"
            @if (in_array($opValue, $value)) checked @endif>
          <span class="colorinput-color bg-primary"></span>
        </label>

      </div>
      <div class="mt-1">
        {{ $opLabel }}
      </div>
    </div>
  @endforeach
  @error($name)
    <div id="{{ $id }}-error-feedback" class="invalid-feedback" style="display: block;" for="{{ $id }}">
      {{ $message }}
    </div>
  @enderror
</div>
