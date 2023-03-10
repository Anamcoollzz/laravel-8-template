@if ($canUpdate || $canDelete || $canDetail)
  <td>
    @if ($canUpdate)
      @include('stisla.includes.forms.buttons.btn-edit', ['link' => route('menu-managements.edit', [$item->id])])
    @endif
    @if ($canDelete)
      @include('stisla.includes.forms.buttons.btn-delete', ['link' => route('menu-managements.destroy', [$item->id])])
    @endif
    @if ($canDetail)
      @include('stisla.includes.forms.buttons.btn-detail', ['link' => route('menu-managements.show', [$item->id])])
    @endif
  </td>
@endif
