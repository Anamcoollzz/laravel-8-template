@php
  $icon = $icon ?? 'fa fa-plus';
  $isAjax = $isAjax ?? false;
  $isAjaxYajra = $isAjaxYajra ?? false;
@endphp

<a @if ($isAjax || $isAjaxYajra) onclick="showModalForm(event, 'create', '{{ $link }}')" @endif class="btn btn-primary @if ($icon ?? false) btn-icon icon-left @endif"
  href="{{ $link }}" @if ($isAjax == false) data-toggle="tooltip" @endif title="{{ $label ?? __('Tambah') }}">
  @if ($icon ?? false)
    <i class="{{ $icon }}"></i>
    {{ $label ?? false }}
  @endif
</a>
