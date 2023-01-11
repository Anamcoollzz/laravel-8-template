@php
  $icon = $icon ?? 'fa fa-pencil-alt';
@endphp
<a class="btn btn-sm btn-danger @if ($icon ?? false) btn-icon icon-left @endif" href="{{ $link }}" data-toggle="tooltip" title="{{ $tooltip ?? ($title ?? __('Danger')) }}">
  @if ($icon ?? false)
    <i class="{{ $icon }}"></i>
  @endif
  {{ $label ?? false }}
</a>
