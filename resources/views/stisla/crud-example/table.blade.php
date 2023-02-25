@php
  $isExport = $isExport ?? false;
  //   dd($isExport);
@endphp

<table class="table table-striped" id="datatable" @if ($isExport === false && $canExport) data-export="true" data-title="{{ __('Contoh CRUD') }}" @endif>
  <thead>
    <tr>
      @if ($isExport)
        <th class="text-center">#</th>
      @else
        <th>{{ __('No') }}</th>
      @endif
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
      @if ($isExport)
        <th>{{ __('Summernote Simple') }}</th>
        <th>{{ __('Summernote') }}</th>
      @endif
      <th>{{ __('Created At') }}</th>
      <th>{{ __('Updated At') }}</th>
      @if ($isExport === false && ($canUpdate || $canDelete))
        <th>{{ __('Aksi') }}</th>
      @endif
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

        @if ($isExport === false)
          <td>
            @if (is_array($item->tags))
              @foreach ($item->tags as $tag)
                <div class="badge badge-primary mb-1">{{ $tag }}</div>
              @endforeach
            @else
              @foreach (explode(',', $item->tags) as $tag)
                <div class="badge badge-primary mb-1">{{ $tag }}</div>
              @endforeach
            @endif
          </td>
        @else
          <td>{{ implode(', ', explode(',', $item->tags)) }}</td>
        @endif

        @if ($isExport)
          <td>
            @if (Str::contains($item->file, 'http'))
              <a href="{{ $item->file }}">{{ $item->file }}</a>
            @elseif($item->file)
              <a href="{{ $urlLink = Storage::url('crud-examples/' . $item->file) }}">{{ $urlLink }}</a>
            @else
              -
            @endif
          </td>
        @else
          <td>
            @if (Str::contains($item->file, 'http'))
              <a class="btn btn-primary btn-sm" href="{{ $item->file }}" target="_blank">Lihat</a>
            @elseif($item->file)
              <a class="btn btn-primary btn-sm" href="{{ Storage::url('crud-examples/' . $item->file) }}" target="_blank">Lihat</a>
            @else
              -
            @endif
          </td>
        @endif

        <td>{{ $item->date }}</td>
        <td>{{ $item->time }}</td>
        <td>
          <div class="p-2 rounded" style="background-color: {{ $item->color }};">{{ $item->color }}
          </div>
        </td>

        @if ($isExport)
          <td>{{ $item->summernote_simple }}</td>
          <td>{{ $item->summernote }}</td>
        @endif

        <td>{{ $item->created_at }}</td>
        <td>{{ $item->updated_at }}</td>

        @if ($isExport === false)
          @if ($canUpdate || $canDelete)
            <td>
              @if ($canUpdate)
                @include('stisla.includes.forms.buttons.btn-edit', ['link' => route('crud-examples.edit', [$item->id])])
              @endif
              @if ($canDelete)
                @include('stisla.includes.forms.buttons.btn-delete', ['link' => route('crud-examples.destroy', [$item->id])])
              @endif
            </td>
          @endif
        @endif
      </tr>
    @endforeach
  </tbody>
</table>
