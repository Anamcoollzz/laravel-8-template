@if ($canUpdate || $canDelete || $canDetail)
  <td>
    @if ($canUpdate)
      @include('stisla.includes.forms.buttons.btn-edit', ['link' => route('group-menus.edit', [$item->id])])
    @endif
    @if ($canDelete)
      @include('stisla.includes.forms.buttons.btn-delete', ['link' => route('group-menus.destroy', [$item->id])])
    @endif
    @if ($canDetail)
      @include('stisla.includes.forms.buttons.btn-detail', ['link' => route('group-menus.show', [$item->id])])
    @endif
  </td>
@endif
