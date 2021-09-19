@php
$icon = $icon ?? 'fa fa-plus';
@endphp
<a class="btn btn-primary @if ($icon ?? false) btn-icon icon-left @endif" href="{{ $link }}" data-toggle="tooltip" title="{{ $label ?? __('Tambah') }}">
  @if ($icon ?? false)
    <i class="{{ $icon }}"></i>
  @endif
  {{ $label ?? false }}
</a>
