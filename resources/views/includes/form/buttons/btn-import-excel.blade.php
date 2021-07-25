@php
$icon = $icon ?? 'fa fa-file-excel';
@endphp
<a onclick="showImportModal(event)" class="btn btn-success @if ($icon ?? false) btn-icon icon-left @endif" href="{{ $link ?? '#' }}" data-toggle="tooltip"
  title="{{ $label ?? __('Impor Excel') }}">
  @if ($icon ?? false)
    <i class="{{ $icon }}"></i>
  @endif
  {{ $label ?? false }}
</a>
