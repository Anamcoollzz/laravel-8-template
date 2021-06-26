<button type="submit" class="btn btn-primary @if ($icon ?? false) btn-icon icon-left @endif">
  @if ($icon ?? false)
    <i class="{{ $icon }}"></i>
  @endif
  {{ $label }}
</button>
