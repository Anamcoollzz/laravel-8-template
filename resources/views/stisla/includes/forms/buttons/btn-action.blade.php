@php
  $isExport = $isExport ?? false;
  $isAjax = $isAjax ?? false;
  $isAjaxYajra = $isAjaxYajra ?? false;
  $isYajra = $isYajra ?? false;
@endphp

@if ($canUpdate || $canDelete || $canDetail)
  <td>
    @if ($canUpdate)
      @include('stisla.includes.forms.buttons.btn-edit', ['link' => route($routePrefix . '.edit', [$item->id])])
    @endif
    @if ($canDelete)
      @include('stisla.includes.forms.buttons.btn-delete', ['link' => route($routePrefix . '.destroy', [$item->id])])
    @endif
    @if ($canDetail)
      @include('stisla.includes.forms.buttons.btn-detail', ['link' => route($routePrefix . '.show', [$item->id])])
    @endif
  </td>
@endif
