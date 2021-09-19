<table class="table table-striped" id="datatable">
  <thead>
    <tr>
      @if ($isExport === false)
        <th class="text-center">#</th>
      @endif
      <th>{{ __('Text') }}</th>
      <th>{{ __('Number') }}</th>
      <th>{{ __('Select') }}</th>
      <th>{{ __('Select2') }}</th>
      <th>{{ __('Select2 Multiple') }}</th>
      <th>{{ __('Textarea') }}</th>
      <th>{{ __('Radio') }}</th>
      <th>{{ __('Checkbox') }}</th>
      <th>{{ __('File') }}</th>
      <th>{{ __('Date') }}</th>
      <th>{{ __('Time') }}</th>
      <th>{{ __('Color') }}</th>
      @if ($isExport === false)
        <th>{{ __('Aksi') }}</th>
      @endif
    </tr>
  </thead>
  <tbody>
    @foreach ($data as $item)
      <tr>
        @if ($isExport === false)
          <td>{{ $loop->iteration }}</td>
        @endif
        <td>{{ $item->text }}</td>
        <td>{{ $item->number }}</td>
        <td>{{ $item->select }}</td>
        <td>{{ $item->select2 }}</td>
        <td>
          {{ is_array($item->select2_multiple) ? implode(', ', $item->select2_multiple) : $item->select2_multiple }}
        </td>
        <td>{{ $item->textarea }}</td>
        <td>{{ $item->radio }}</td>
        <td>{{ is_array($item->checkbox) ? implode(', ', $item->checkbox) : $item->checkbox }}</td>
        <td>
          @if (Str::contains($item->file, 'http'))
            <a href="{{ $item->file }}" target="_blank">Lihat</a>
          @else
            <a href="{{ Storage::url('crud-examples/' . $item->file) }}" target="_blank">Lihat</a>
          @endif
        </td>
        <td>{{ $item->date }}</td>
        <td>{{ $item->time }}</td>
        <td>
          <div class="p-2 rounded" style="background-color: {{ $item->color }};">{{ $item->color }}
          </div>
        </td>
        @if ($isExport === false)
          <td>
            @include('stisla.includes.forms.buttons.btn-edit', ['link'=>route('crud-examples.edit',
            [$item->id])])
            @include('stisla.includes.forms.buttons.btn-delete', ['link'=>route('crud-examples.destroy',
            [$item->id])])
          </td>
        @endif
      </tr>
    @endforeach
  </tbody>
</table>
