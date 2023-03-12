@php
  $icon = $icon ?? 'fa fa-eye';
  $isAjax = $isAjax ?? false;
  $isAjaxYajra = $isAjaxYajra ?? false;
@endphp
<a @if ($isAjax || $isAjaxYajra) onclick="showModalForm(event, 'detail', '{{ $link }}')" @endif class="btn btn-sm btn-primary @if ($icon ?? false) btn-icon icon-left @endif"
  href="{{ $link }}" data-toggle="tooltip" title="{{ $label ?? __('Detail') }}">
  @if ($icon ?? false)
    <i class="{{ $icon }}"></i>
  @endif
  {{ $label ?? false }}
</a>
