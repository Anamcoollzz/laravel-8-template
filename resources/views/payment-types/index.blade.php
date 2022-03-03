@extends($data->count() > 0 ? 'stisla.layouts.app-table' : 'stisla.layouts.app')

@section('title')
  {{ $title = 'Jenis Pembayaran' }}
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
              <h4><i class="fa fa-certificate"></i> Data {{ $title }}</h4>
              <div class="card-header-action">
                {{-- @can('Jenis Pembayaran Impor Excel') --}}
                @include('stisla.includes.forms.buttons.btn-import-excel')
                {{-- @endcan --}}
                {{-- @can('Jenis Pembayaran Tambah') --}}
                @include('stisla.includes.forms.buttons.btn-add', ['link'=>route('payment-types.create')])
                {{-- @endcan --}}
              </div>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped" id="datatable">
                  <thead>
                    <tr>
                      <th class="text-center">{{ __('#') }}</th>
                      <th class="text-center">{{ __('Nama Pembayaran') }}</th>
                      <th class="text-center">{{ __('Tagihan') }}</th>
                      <th class="text-center">{{ __('Jenis Waktu Pembayaran') }}</th>

                      <th>{{ __('Aksi') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($data as $item)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->type_name }}</td>
                        <td>{{ $item->bill_amount }}</td>
                        <td>{{ $item->payment_time_type }}</td>

                        <td>
                          {{-- @can('Jenis Pembayaran Ubah') --}}
                          @include('stisla.includes.forms.buttons.btn-edit', ['link'=>route('payment-types.edit', [$item->id])])
                          {{-- @can('Jenis Pembayaran Hapus') --}}
                          @include('stisla.includes.forms.buttons.btn-delete', ['link'=>route('payment-types.destroy', [$item->id])])
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
          @include('stisla.includes.others.empty-state', ['title'=>'Data '.$title, 'icon'=>'fa fa-certificate','link'=>route('payment-types.create')])
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
  @include('stisla.includes.modals.modal-import-excel', ['formAction'=>route('payment-types.import-excel'),
  'downloadLink'=>route('payment-types.import-excel-example')])
@endpush
