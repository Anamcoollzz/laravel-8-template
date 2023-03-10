@php
  $isExport = $isExport ?? false;
@endphp

<table class="table table-striped yajra-datatable" @if ($isYajra === false) id="datatable" @endif
  @if ($isExport === false && $canExport) data-export="true" data-title="{{ __('Contoh CRUD') }}" @endif>
  <thead>
    <tr>
      @if ($isExport)
        <th class="text-center">#</th>
      @else
        <th>{{ __('No') }}</th>
      @endif
      <th>{{ __('Nama Grup') }}</th>
      <th>{{ __('Created At') }}</th>
      <th>{{ __('Updated At') }}</th>
      @if ($isExport === false && ($canUpdate || $canDelete || $canDetail))
        <th>{{ __('Aksi') }}</th>
      @endif
    </tr>
  </thead>
  <tbody>
    @if ($isYajra === false)
      @foreach ($data as $item)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $item->group_name }}</td>
          <td>{{ $item->created_at }}</td>
          <td>{{ $item->updated_at }}</td>

          @if ($isExport === false)
            @include('stisla.group-menus.action')
          @endif
        </tr>
      @endforeach
    @endif
  </tbody>
</table>
