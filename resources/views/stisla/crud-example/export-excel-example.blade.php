<table class="table table-striped" id="datatable">
  <thead>
    <tr>
      <th>{{ __('No') }}</th>
      <th>{{ __('Text') }}</th>
      <th>{{ __('Number') }}</th>
      <th>{{ __('Currency') }}</th>
      <th>{{ __('Currency IDR') }}</th>
      <th>{{ __('Select') }}</th>
      <th>{{ __('Select2') }}</th>
      <th>{{ __('Select2 Multiple') }}</th>
      <th>{{ __('Textarea') }}</th>
      <th>{{ __('Radio') }}</th>
      <th>{{ __('Checkbox') }}</th>
      <th>{{ __('Checkbox 2') }}</th>
      <th>{{ __('Tags') }}</th>
      <th>{{ __('File') }}</th>
      <th>{{ __('Date') }}</th>
      <th>{{ __('Time') }}</th>
      <th>{{ __('Color') }}</th>
      <th>{{ __('Summernote Simple') }}</th>
      <th>{{ __('Summernote') }}</th>
      <th>{{ __('Created At') }}</th>
      <th>{{ __('Updated At') }}</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($data as $item)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $item->text }}</td>
        <td>{{ $item->number }}</td>
        <td>{{ dollar($item->currency) }}</td>
        <td>{{ rp($item->currency_idr) }}</td>
        <td>{{ $item->select }}</td>
        <td>{{ $item->select2 }}</td>
        <td>
          {{ is_array($item->select2_multiple) ? implode(', ', $item->select2_multiple) : $item->select2_multiple }}
        </td>
        <td>{{ $item->textarea }}</td>
        <td>{{ $item->radio }}</td>
        <td>{{ is_array($item->checkbox) ? implode(', ', $item->checkbox) : $item->checkbox }}</td>
        <td>{{ is_array($item->checkbox2) ? implode(', ', $item->checkbox2) : $item->checkbox2 }}</td>
        <td>{{ $item->tags }}</td>
        <td>
          @if (Str::contains($item->file, 'http'))
            {{ $item->file }}
          @elseif($item->file)
            {{ Storage::url('crud-examples/' . $item->file) }}
          @else
            -
          @endif
        </td>
        <td>{{ $item->date }}</td>
        <td>{{ $item->time }}</td>
        <td>
          <div class="p-2 rounded" style="background-color: {{ $item->color }};">{{ $item->color }}
          </div>
        </td>
        <td>{{ $item->summernote_simple }}</td>
        <td>{{ $item->summernote }}</td>
        <td>{{ $item->created_at }}</td>
        <td>{{ $item->updated_at }}</td>
      </tr>
    @endforeach
  </tbody>
</table>
