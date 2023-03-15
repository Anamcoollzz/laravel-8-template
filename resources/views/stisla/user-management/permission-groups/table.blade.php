@php
  $isExport = $isExport ?? false;
  $canAction = $canUpdate || $canDelete || $canDetail;
@endphp

<table class="table table-striped" id="datatable" @can('Group Permission Ekspor') data-export="true" data-title="{{ __('Group Permission') }}" @endcan>
  <thead>
    <tr>
      <th class="text-center">#</th>
      <th>{{ __('Group') }}</th>
      <th>{{ __('Created At') }}</th>
      <th>{{ __('Updated At') }}</th>
      @if ($isExport == false && $canAction)
        <th>{{ __('Aksi') }}</th>
      @endif
    </tr>
  </thead>
  <tbody>
    @foreach ($data as $item)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->group_name }}</td>
        <td>{{ $item->created_at }}</td>
        <td>{{ $item->updated_at }}</td>
        @if ($isExport == false && $canAction)
          <td>
            @if ($canUpdate)
              @include('stisla.includes.forms.buttons.btn-edit', ['link' => route($routePrefix . '.edit', [$item->id])])
            @endif
            @if ($canDelete)
              @include('stisla.includes.forms.buttons.btn-delete', ['link' => route($routePrefix . '.destroy', [$item->id])])
            @endif
            @if ($canDelete)
              @include('stisla.includes.forms.buttons.btn-detail', ['link' => route($routePrefix . '.destroy', [$item->id])])
            @endif
          </td>
        @endif
      </tr>
    @endforeach
  </tbody>
</table>
