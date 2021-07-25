@extends($data->count() > 0 ? 'stisla.layouts.app-table' : 'stisla.layouts.app')

@section('title')
  {{ $title = 'Mahasiswa' }}
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
              <h4><i class="fa fa-users"></i> Data {{ $title }}</h4>
              <div class="card-header-action">
                {{-- @can('Mahasiswa Impor Excel') --}}
                @include('includes.form.buttons.btn-import-excel')
                {{-- @endcan --}}
                {{-- @can('Mahasiswa Tambah') --}}
                @include('includes.form.buttons.btn-add', ['link'=>route('mahasiswas.create')])
                {{-- @endcan --}}
              </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped" id="datatable">
                  <thead>
                    <tr>
                      <th class="text-center">{{ __('#') }}</th>
		<th class="text-center">{{ __('Full Name') }}</th>
		<th class="text-center">{{ __('Birth Date') }}</th>
		<th class="text-center">{{ __('Select2') }}</th>
		<th class="text-center">{{ __('Select') }}</th>
		<th class="text-center">{{ __('Colorpicker') }}</th>
		<th class="text-center">{{ __('Number') }}</th>
		<th class="text-center">{{ __('Image') }}</th>
		<th class="text-center">{{ __('File') }}</th>
		<th class="text-center">{{ __('Password') }}</th>
		<th class="text-center">{{ __('Email') }}</th>
		<th class="text-center">{{ __('Time') }}</th>
		<th class="text-center">{{ __('Address') }}</th>
		<th class="text-center">{{ __('Gender') }}</th>

                      <th>{{ __('Aksi') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($data as $item)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
		<td>{{ $item->name }}</td>
		<td>{{ $item->birth_date }}</td>
		<td>{{ $item->select2 }}</td>
		<td>{{ $item->select }}</td>
		<td>{{ $item->colorpicker }}</td>
		<td>{{ $item->number }}</td>
		<td>{{ $item->image }}</td>
		<td>{{ $item->file }}</td>
		<td>{{ $item->password }}</td>
		<td>{{ $item->email }}</td>
		<td>{{ $item->time }}</td>
		<td>{{ $item->address }}</td>
		<td>{{ \App\Models\Mahasiswa::TYPES['gender'][$item->gender] }}</td>

                        <td>
                          {{-- @can('Mahasiswa Ubah') --}}
                            @include('includes.form.buttons.btn-edit', ['link'=>route('mahasiswas.edit', [$item->id])])
                          {{-- @can('Mahasiswa Hapus') --}}
                            @include('includes.form.buttons.btn-delete', ['link'=>route('mahasiswas.destroy', [$item->id])])
                          {{-- @endcan --}}
                        </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        @else
          @include('includes.empty-state', ['title'=>'Data '.$title, 'icon'=>'fa fa-users','link'=>route('mahasiswas.create')])
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
  @include('includes.modals.modal-import-excel', ['formAction'=>route('mahasiswas.import-excel'),
  'downloadLink'=>route('mahasiswas.import-excel-example')])

@endpush
