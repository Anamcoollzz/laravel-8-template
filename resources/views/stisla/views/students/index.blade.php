@extends('stisla.layouts.app-table')

@section('title')
  {{ $title = 'Siswa' }}
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
        <div class="card">
          <div class="card-header">
            <h4><i class="fa fa-certificate"></i>Filter Data {{ $title }}</h4>

          </div>
          <div class="card-body">
            <form action="">
              <div class="row">
                <div class="col-md-4">
                  @include('stisla.includes.forms.selects.select', ['id'=>'kelas', 'label'=>'Kelas', 'options'=>['7'=>'7','8'=>'8']])
                </div>
                <div class="col-md-4">
                  @include('stisla.includes.forms.selects.select', ['id'=>'kelas', 'label'=>'Grup Kelas', 'options'=>['A'=>'A','B'=>'B']])
                </div>
                <div class="col-md-4">
                  @include('stisla.includes.forms.selects.select', ['id'=>'kelas', 'label'=>'Tahun Ajaran', 'options'=>['2020/2021'=>'2020/2021','2021/2022'=>'2021/2022']])
                </div>
                <div class="col-md-4">
                  @include('stisla.includes.forms.inputs.input', ['id'=>'kelas', 'label'=>'Bisa Menggunakan Nama', 'options'=>['2020/2021'=>'2020/2021','2021/2022'=>'2021/2022']])
                </div>
                <div class="col-md-4">
                  @include('stisla.includes.forms.inputs.input', ['id'=>'kelas', 'label'=>'Atau Menggunakan NIS', 'options'=>['2020/2021'=>'2020/2021','2021/2022'=>'2021/2022']])
                </div>
                <div class="col-md-12">
                  @include('stisla.includes.forms.buttons.btn-save', ['label'=>'Filter'])
                </div>
              </div>
            </form>
          </div>
        </div>

        <div class="card">

          <div class="card-body">
            Di Tahun ajaran 2020/2021 terdapat Laki-laki: 400, Perempuan: 300, Total: 700
          </div>
        </div>

        <div class="card">
          <div class="card-header">
            <h4><i class="fa fa-certificate"></i> Data {{ $title }}</h4>
            <div class="card-header-action">
              {{-- @can('Siswa Impor Excel') --}}
              @include('stisla.includes.forms.buttons.btn-import-excel')
              {{-- @endcan --}}
              {{-- @can('Siswa Tambah') --}}
              @include('stisla.includes.forms.buttons.btn-add', ['link'=>route('views.school-years.create')])
              {{-- @endcan --}}
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped" id="datatable">
                <thead>
                  <tr>
                    <th class="text-center">{{ __('#') }}</th>
                    <th class="text-center">{{ __('Siswa') }}</th>
                    <th class="text-center">{{ __('NIS') }}</th>
                    <th class="text-center">{{ __('Jenis Kelamin') }}</th>
                    <th class="text-center">{{ __('Kelas') }}</th>
                    <th class="text-center">{{ __('Grup Kelas') }}</th>
                    <th class="text-center">{{ __('Tahun Ajaran') }}</th>
                    <th class="text-center">{{ __('No HP') }}</th>
                    <th class="text-center">{{ __('Alamat') }}</th>
                    <th class="text-center">{{ __('Orang Tua / Wali') }}</th>

                    <th>{{ __('Aksi') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach (collect(['2018/2019', '2019/2020', '2020/2021', '2021/2022'])->reverse() as $item)
                    <tr>
                      <td>1</td>
                      <td>Nama Siswa {{ $loop->iteration }}</td>
                      <td>{{ $loop->iteration . $loop->iteration . $loop->iteration . $loop->iteration . $loop->iteration }}</td>
                      <td>{{ $loop->iteration > 2 ? 'Laki-laki' : 'Perempuan' }}</td>
                      <td>7</td>
                      <td>A</td>
                      <td>{{ $item }}</td>
                      <td>08{{ $loop->iteration }}32xxxxx</td>
                      <td>Alamat Siswa {{ $loop->iteration }}</td>
                      <td>Nama Orang Tua / Wali {{ $loop->iteration }}</td>

                      <td>
                        {{-- @can('Siswa Ubah') --}}
                        @include('stisla.includes.forms.buttons.btn-edit', ['link'=>route('views.school-years.edit', [1])])
                        {{-- @can('Siswa Hapus') --}}
                        @include('stisla.includes.forms.buttons.btn-delete')
                        {{-- @endcan --}}
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>

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
  @include('stisla.includes.modals.modal-import-excel', ['formAction'=>route('payment-types.import-excel'),
  'downloadLink'=>route('payment-types.import-excel-example')])
@endpush
