@php
$icon = $icon ?? 'fa fa-eye';
@endphp
<a class="btn btn-primary @if ($icon ?? false) btn-icon icon-left @endif" href="{{ $link }}" data-toggle="tooltip"
  title="{{ $label ?? __('Lihat Data') }}">
  @if ($icon ?? false)
    <i class="{{ $icon }}"></i>
  @endif
  {{ $label ?? false }}
</a>
