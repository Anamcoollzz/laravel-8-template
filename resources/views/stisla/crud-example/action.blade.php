@if ($canUpdate || $canDelete || $canDetail)
  <td>
    @if ($canUpdate)
      @include('stisla.includes.forms.buttons.btn-edit', ['link' => route('crud-examples.edit', [$item->id])])
    @endif
    @if ($canDelete)
      @include('stisla.includes.forms.buttons.btn-delete', ['link' => route('crud-examples.destroy', [$item->id])])
    @endif
    @if ($canDetail)
      @include('stisla.includes.forms.buttons.btn-detail', ['link' => route('crud-examples.show', [$item->id])])
    @endif
  </td>
@endif
