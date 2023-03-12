@php
  $icon = $icon ?? 'fa fa-pencil-alt';
  $isAjax = $isAjax ?? false;
  $isAjaxYajra = $isAjaxYajra ?? false;
@endphp
<a @if ($isAjax || $isAjaxYajra) onclick="showModalForm(event, 'edit', '{{ $link }}')" @endif class="btn btn-sm btn-primary @if ($icon ?? false) btn-icon icon-left @endif"
  href="{{ $link }}" @if (!$isAjax) data-toggle="tooltip" @endif title="{{ $tooltip ?? ($label ?? __('Ubah')) }}">
  @if ($icon ?? false)
    <i class="{{ $icon }}"></i>
  @endif
  {{ $label ?? false }}
</a>
