@php
$icon = $icon ?? 'fa fa-trash';
@endphp
<a onclick="deleteGlobal(event, '{{ $link ?? false }}')" class="btn btn-sm btn-danger @if ($icon ?? false) btn-icon icon-left @endif" href="#" data-toggle="tooltip"
  title="{{ $label ?? __('Hapus') }}">
  @if ($icon ?? false)
    <i class="{{ $icon }}"></i>
  @endif
  {{ $label ?? false }}
</a>
