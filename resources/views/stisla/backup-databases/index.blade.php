@extends('stisla.layouts.app-table')

@section('title', $title)

@section('content')
  @include('stisla.includes.breadcrumbs.breadcrumb-table')

  <div class="section-body">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>
              <i class="fa fa-filter"></i>
              Filter berdasarkan bulan dan tahun
            </h4>
          </div>
          <div class="card-body">
            <form action="">
              @csrf
              <div class="row">
                <div class="col-md-6">
                  @include('stisla.includes.forms.selects.select', [
                      'id' => 'filter_month',
                      'name' => 'filter_month',
                      'options' => $array_bulan,
                      'label' => 'Bulan',
                      'required' => true,
                      'selected' => $month,
                  ])
                </div>
                <div class="col-md-6">
                  @include('stisla.includes.forms.selects.select', [
                      'id' => 'filter_year',
                      'name' => 'filter_year',
                      'options' => $array_year,
                      'label' => 'Tahun',
                      'required' => true,
                      'selected' => $year,
                  ])
                </div>
              </div>

              <button type="submit" class="btn btn-primary">Lihat</button>

            </form>
          </div>
        </div>
      </div>

      <div class="col-12">
        <div class="alert alert-info">
          Menampilkan data backup database di periode {{ namaBulan($month) }} {{ $year }}
        </div>
      </div>

      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4>
              {{-- <i class="fa fa-database"></i> Data --}}
            </h4>
            @if (Auth::check())
              <div class="card-header-action">
                <a href="{{ route('backup-databases.create') }}" class="btn btn-primary float-right pull-right">
                  <i class="fa fa-plus"></i> Backup Sekarang
                </a>
              </div>
            @endif
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped" id="datatable">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Ukuran</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($data as $d)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>
                        <a class="" href="{{ $d['url'] }}" target="_blank">
                          {{ $name = $d['name'] }}
                        </a>
                      </td>
                      @if ($d['size_on_gb'] > 0)
                        <td>{{ $d['size_on_gb'] }} GB</td>
                      @elseif($d['size_on_mb'] > 0)
                        <td>{{ $d['size_on_mb'] }} MB</td>
                      @else
                        <td>{{ $d['size_on_kb'] }} KB</td>
                      @endif
                      <td>
                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton{{ $loop->iteration }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          Aksi
                        </button>
                        <div class="dropdown-menu">
                          <a onclick="hapus(event, '{{ route('backup-databases.destroy', $name) }}')" class="dropdown-item has-icon text-danger" href="#">
                            <i class="fas fa-trash"></i> Hapus
                          </a>
                          <a onclick="restore(event, '{{ route('backup-databases.update', $name) }}')" class="dropdown-item has-icon" href="#">
                            <i class="fas fa-undo"></i> Restore
                          </a>
                          <a class="dropdown-item has-icon" href="{{ $d['url'] }}" target="_blank">
                            <i class="fas fa-download"></i> Unduh
                          </a>
                        </div>
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

@if (Auth::check())
  @push('scripts')
    <form action="" id="form-hapus" method="post">
      @csrf
      @method('DELETE')
    </form>
    <form action="" id="form-update" method="post">
      @csrf
      @method('PUT')
    </form>
    <script>
      function hapus(e, url) {
        e.preventDefault()
        swal({
            title: 'Anda yakin?',
            text: 'Sekali dihapus, data tidak akan kembali lagi!',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
            buttons: {
              cancel: {
                text: "Batal",
                value: null,
                visible: true,
                className: "",
                closeModal: true,
              },
              confirm: {
                text: "Lanjutkan",
              }
            }
          })
          .then((onYes) => {
            if (onYes) {
              $('#form-hapus').attr('action', url);
              document.getElementById('form-hapus').submit();
            } else {
              swal('Okay, tidak jadi');
            }
          });
      }

      function restore(e, url) {
        e.preventDefault()
        swal({
            title: 'Anda yakin?',
            text: 'Sekali restore, data akan dikembalikan ke tanggal tersebut!',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
            buttons: {
              cancel: {
                text: "Batal",
                value: null,
                visible: true,
                className: "",
                closeModal: true,
              },
              confirm: {
                text: "Lanjutkan",
              }
            }
          })
          .then((onYes) => {
            if (onYes) {
              $('#form-update').attr('action', url);
              document.getElementById('form-update').submit();
            } else {
              swal('Okay, tidak jadi');
            }
          });
      }
    </script>
  @endpush
@endif

@push('modal')
@endpush

@push('js')
@endpush

{{-- @include('stisla.import.axios') --}}
