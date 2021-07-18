@extends('stisla.layouts.app-table')

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
              {{-- @can('Mahasiswa Tambah') --}}
              <div class="card-header-action">
                @include('includes.form.buttons.btn-add', ['link'=>route('mahasiswas.create')])
              </div>
              {{-- @endcan --}}
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped" id="datatable">
                  <thead>
                    <tr>
                      <th class="text-center">{{ __('#') }}</th>
						<th class="text-center">{{ __('Name') }}</th>
						<th class="text-center">{{ __('Birth Date') }}</th>
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
