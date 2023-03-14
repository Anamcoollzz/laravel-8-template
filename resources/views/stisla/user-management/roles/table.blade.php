@php
  $canAction = $canUpdate || $canDelete;
@endphp
<table class="table table-striped" id="datatable" @can('Role Ekspor') data-export="true" data-title="{{ __('Role') }}" @endcan>
  <thead>
    <tr>
      <th class="text-center">#</th>
      <th>{{ __('Role') }}</th>
      @if ($canAction)
        <th>{{ __('Aksi') }}</th>
      @endif
    </tr>
  </thead>
  <tbody>
    @foreach ($data as $item)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>
          {{ $item->name }}
        </td>
        @if ($canAction)
          <td>
            @if ($canUpdate)
              @if ($item->name === 'superadmin')
                @include('stisla.includes.forms.buttons.btn-detail', ['link' => route('user-management.roles.edit', [$item->id])])
              @else
                @include('stisla.includes.forms.buttons.btn-edit', ['link' => route('user-management.roles.edit', [$item->id])])
              @endif
            @endif
            @if ($canDelete && !$item->is_locked)
              @include('stisla.includes.forms.buttons.btn-delete', ['link' => route('user-management.roles.destroy', [$item->id])])
            @endif
          </td>
        @endif
      </tr>
    @endforeach
  </tbody>
</table>
