@php
  $isExport = $isExport ?? false;
@endphp

<table class="table table-striped" id="datatable" @can('Permission Ekspor') data-export="true" data-title="{{ __('Permission') }}" @endcan>
  <thead>
    <tr>
      <th class="text-center">#</th>
      <th>{{ __('Group') }}</th>
      <th>{{ __('Permission') }}</th>
      <th>{{ __('Created At') }}</th>
      <th>{{ __('Updated At') }}</th>
      @if ($isExport === false)
        <th>{{ __('Aksi') }}</th>
      @endif
    </tr>
  </thead>
  <tbody>
    @foreach ($data as $item)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->group_name }}</td>
        <td>{{ $item->name }}</td>
        <td>{{ $item->created_at }}</td>
        <td>{{ $item->updated_at }}</td>
        @if ($isExport === false)
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
      </tr>
    @endforeach
  </tbody>
</table>
