<div class="form-group {{ $errors->has($name ?? $id) ? 'has-error' : '' }}">
  <label @isset($id) for="{{ $id }}" @endisset>
    {{ $label }}
    @if ($required ?? false) <span class="text-danger">*</span> @endif
  </label>
  <textarea @if ($placeholder ?? false) placeholder="{{ $placeholder }}" @endif name="{{ $name ?? $id }}" @isset($id) id="{{ $id }}" @endisset @isset($disabled)
    disabled @endisset @if ($required ?? false) required
  @endif @if ($min ?? false) min="{{ $min }}" @endif
  class="form-control">{{ old($name ?? $id, $d->$name ?? ($d->$id ?? '')) }}</textarea>

  <span class="text-danger">
    @if ($errors->has($name ?? $id))
      {{ $errors->first($name ?? $id) }}
    @endif
  </span>

  @if ($hint ?? false)
    <span class="text-black">{{ $hint }}</span>
  @endif
</div>
