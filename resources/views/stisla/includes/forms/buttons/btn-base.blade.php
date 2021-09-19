@if (($type ?? false) === 'submit')
  <button type="submit" class="btn btn-{{ $variant }} @if ($icon ?? false) btn-icon icon-left @endif">
    @if ($icon ?? false)
      <i class="{{ $icon }}"></i>
    @endif
    {{ $label }}
  </button>

@else
  <a class="btn btn-{{ $variant }} @if ($icon ?? false) btn-icon icon-left @endif" href="{{ $link ?? '#' }}">
    @if ($icon ?? false)
      <i class="{{ $icon }}"></i>
    @endif
    {{ $label }}
  </a>
@endif
