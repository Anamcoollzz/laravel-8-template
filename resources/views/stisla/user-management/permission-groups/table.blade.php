@php
  $isExport = $isExport ?? false;
@endphp

<table class="table table-striped" id="datatable" @can('Group Permission Ekspor') data-export="true" data-title="{{ __('Group Permission') }}" @endcan>
  <thead>
    <tr>
      <th class="text-center">#</th>
      <th>{{ __('Group') }}</th>
      @if ($isExport == false)
        <th>{{ __('Created At') }}</th>
        <th>{{ __('Updated At') }}</th>
        <th>{{ __('Aksi') }}</th>
      @endif
    </tr>
  </thead>
  <tbody>
    @foreach ($data as $item)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->group_name }}</td>
        @if ($isExport == false)
          <td>{{ $item->created_at }}</td>
          <td>{{ $item->updated_at }}</td>
          <td>
            @if ($canUpdate)
              @include('stisla.includes.forms.buttons.btn-edit', ['link' => route('user-management.permission-groups.edit', [$item->id])])
            @endif
            @if ($canDelete)
              @include('stisla.includes.forms.buttons.btn-delete', ['link' => route('user-management.permission-groups.destroy', [$item->id])])
            @endif
          </td>
        @endif
      </tr>
    @endforeach
  </tbody>
</table>
