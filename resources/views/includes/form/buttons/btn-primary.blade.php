<button type="submit" class="btn btn-primary btn-lg @if ($icon ?? false) btn-icon icon-left @endif" tabindex="4">
  @if ($icon ?? false)
    <i class="{{ $icon }}"></i>
  @endif
  {{ $label }}
</button>
