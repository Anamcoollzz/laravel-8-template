@php
$icon = $icon ?? 'fa fa-edit';
@endphp
<a class="btn btn-sm btn-primary @if ($icon ?? false) btn-icon icon-left @endif" href="{{ $link }}" data-toggle="tooltip" title="{{ $label ?? __('Ubah') }}">
  @if ($icon ?? false)
    <i class="{{ $icon }}"></i>
  @endif
  {{ $label ?? false }}
</a>
