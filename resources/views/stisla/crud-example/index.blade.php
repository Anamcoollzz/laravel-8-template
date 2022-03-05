@extends($data->count() > 0 ? 'stisla.layouts.app-table' : 'stisla.layouts.app')

@section('title')
  {{ $title }}
@endsection

@section('content')
  @include('stisla.includes.breadcrumbs.breadcrumb-table')

  <div class="section-body">
    <h2 class="section-title">{{ $title }}</h2>
    <p class="section-lead">{{ __('Menampilkan halaman ' . $title) }}.</p>
    <div class="row">
      <div class="col-12">
        @if ($data->count() > 0)
          @if ($canExport)
            <div class="card">
              <div class="card-header">
                <h4><i class="fa fa-atom"></i> {!! __('Aksi Ekspor <small>(Server Side)</small>') !!}</h4>
                <div class="card-header-action">
                  @include('stisla.includes.forms.buttons.btn-pdf-download', ['link' => route('crud-examples.pdf')])
                  @include('stisla.includes.forms.buttons.btn-excel-download', ['link' => route('crud-examples.excel')])
                  @include('stisla.includes.forms.buttons.btn-csv-download', ['link' => route('crud-examples.csv')])
                  @include('stisla.includes.forms.buttons.btn-json-download', ['link' => route('crud-examples.json')])
                </div>
              </div>
            </div>
          @endif

          <div class="card">
            <div class="card-header">
              <h4><i class="fa fa-atom"></i> Data {{ $title }}</h4>

              <div class="card-header-action">
                @if ($canImportExcel)
                  @include('stisla.includes.forms.buttons.btn-import-excel')
                @endif
                @if ($canCreate)
                  @include('stisla.includes.forms.buttons.btn-add', ['link' => route('crud-examples.create')])
                @endif
              </div>
            </div>
            <div class="card-body">
              @include('stisla.includes.forms.buttons.btn-datatable')
              <div class="table-responsive">
                <table class="table table-striped" id="datatable" @if ($canExport) data-export="true" data-title="{{ __('Role') }}" @endif>
                  <thead>
                    <tr>
                      <th class="text-center">#</th>
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
                      @if ($canUpdate || $canDelete)
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
                      </tr>
                    @endforeach
                  </tbody>
                </table>

              </div>
            </div>
          </div>
        @else
          @include('stisla.includes.others.empty-state', ['title' => 'Data ' . $title, 'icon' => 'fa fa-atom', 'link' => route('crud-examples.create')])
        @endif
      </div>

    </div>
  </div>

@endsection

@push('css')
@endpush

@push('js')
@endpush

@push('scripts')
  <script>

  </script>
@endpush

@push('modals')
  @if ($canImportExcel)
    @include('stisla.includes.modals.modal-import-excel', [
        'formAction' => route('crud-examples.import-excel'),
        'downloadLink' => route('crud-examples.import-excel-example'),
    ])
  @endif
@endpush
