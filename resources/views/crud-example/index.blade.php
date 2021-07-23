@extends('stisla.layouts.app-table')

@section('title')
  {{ $title = 'Contoh CRUD' }}
@endsection

@section('content')
  <div class="section-header">
    <h1>{{ $title }}</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active">
        <a href="{{ route('dashboard.index') }}">{{ __('Dashboard') }}</a>
      </div>
      <div class="breadcrumb-item">{{ $title }}</div>
    </div>
  </div>

  <div class="section-body">
    <div class="row">
      <div class="col-12">
        @if ($data->count() > 0)
          <div class="card">
            <div class="card-header">
              <h4><i class="fa fa-atom"></i> Data {{ $title }}</h4>
              {{-- @can('Contoh CRUD Tambah') --}}
              <div class="card-header-action">
                @include('includes.form.buttons.btn-add', ['link'=>route('crud-examples.create')])
              </div>
              {{-- @endcan --}}
            </div>
            <div class="card-body">
              @include('stisla.includes.datatable-buttons')
              <div class="table-responsive">
                <table class="table table-striped" id="datatable">
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
                      <th>{{ __('Aksi') }}</th>
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
                        <td>{{ implode(', ', $item->select2_multiple) }}</td>
                        <td>{{ $item->textarea }}</td>
                        <td>{{ $item->radio }}</td>
                        <td>{{ implode(', ', $item->checkbox) }}</td>
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
                        <td>
                          @include('includes.form.buttons.btn-edit', ['link'=>route('crud-examples.edit',
                          [$item->id])])
                          @include('includes.form.buttons.btn-delete', ['link'=>route('crud-examples.destroy',
                          [$item->id])])
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        @else
          @include('includes.empty-state', ['title'=>'Data '.$title, 'icon'=>'fa
          fa-atom','link'=>route('crud-examples.create')])
        @endif
      </div>

    </div>
  </div>
@endsection


@push('css')

@endpush

@push('js')

@endpush
