@php
  $isExport = $isExport ?? false;
  //   dd($isExport);
@endphp

<table class="table table-striped @if ($isYajra) yajra-datatable @endif"
  @if ($isYajra === false) id="datatable" @else data-ajax-url="{{ $routeYajra }}" data-ajax-columns='{!! $yajraColumns !!}' @endif
  @if ($isExport === false && $canExport) data-export="true" data-title="{{ __('Contoh CRUD') }}" @endif>
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
              @include('stisla.crud-example.tags', ['tags' => $item->tags])
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
              @include('stisla.crud-example.file', ['file' => $item->file])
            </td>
          @endif

          <td>{{ $item->date }}</td>
          <td>{{ $item->time }}</td>
          <td>
            @include('stisla.crud-example.color', ['color' => $item->color])
          </td>

          @if ($isExport)
            <td>{{ $item->summernote_simple }}</td>
            <td>{{ $item->summernote }}</td>
          @endif

          <td>{{ $item->created_at }}</td>
          <td>{{ $item->updated_at }}</td>

          @if ($isExport === false)
            @include('stisla.crud-example.action')
          @endif
        </tr>
      @endforeach
    @endif
  </tbody>
</table>
