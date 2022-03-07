@extends($data->count() > 0 ? 'stisla.layouts.app-table' : 'stisla.layouts.app')

@section('title')
  {{ $title }}
@endsection

@section('content')
  @include('stisla.includes.breadcrumbs.breadcrumb-table')

  <div class="section-body">

    <h2 class="section-title">{{ $title }}</h2>
    <p class="section-lead">{{ __('Merupakan halaman yang menampilkan kumpulan data ' . $title) }}.</p>

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4><i class="fa fa-filter"></i> Filter Data</h4>
            <div class="card-header-action">
            </div>
          </div>
          <div class="card-body">

            <form action="">
              @csrf
              <div class="row">
                <div class="col-md-3">
                  @include('stisla.includes.forms.inputs.input', [
                      'type' => 'date',
                      'id' => 'filter_date',
                      'required' => true,
                      'label' => __('Masukkan Tanggal'),
                      'value' => request('filter_date', date('Y-m-d')),
                  ])
                </div>
                <div class="col-md-3">
                  @include('stisla.includes.forms.selects.select2', [
                      'id' => 'filter_user',
                      'name' => 'filter_user',
                      'label' => __('Pilih Pengguna'),
                      'options' => $users,
                      'selected' => request('filter_user'),
                      'with_all' => true,
                  ])
                </div>
                <div class="col-md-3">
                  @include('stisla.includes.forms.selects.select2', [
                      'id' => 'filter_role',
                      'name' => 'filter_role',
                      'label' => __('Pilih Role'),
                      'options' => $roles,
                      'selected' => request('filter_role'),
                      'with_all' => true,
                  ])
                </div>
                <div class="col-md-3">
                  @include('stisla.includes.forms.selects.select2', [
                      'id' => 'filter_kind',
                      'name' => 'filter_kind',
                      'label' => __('Pilih Jenis Aktivitas'),
                      'options' => $kinds,
                      'selected' => request('filter_kind'),
                      'with_all' => true,
                  ])
                </div>
              </div>
              <button class="btn btn-primary icon"><i class="fa fa-search"></i> Cari Data</button>
            </form>
          </div>
        </div>

        @if ($data->count() > 0)
          @if ($canExport)
            <div class="card">
              <div class="card-header">
                <h4><i class="fa fa-fa fa-clock-rotate-left"></i> {!! __('Aksi Ekspor <small>(Server Side)</small>') !!}</h4>
                <div class="card-header-action">
                  @include('stisla.includes.forms.buttons.btn-pdf-download', ['link' => $routePdf])
                  @include('stisla.includes.forms.buttons.btn-excel-download', ['link' => $routeExcel])
                  @include('stisla.includes.forms.buttons.btn-csv-download', ['link' => $routeCsv])
                  @include('stisla.includes.forms.buttons.btn-print', ['link' => $routePrint])
                  @include('stisla.includes.forms.buttons.btn-json-download', ['link' => $routeJson])
                </div>
              </div>
            </div>
          @endif

          <div class="card">
            <div class="card-header">
              <h4><i class="fa fa-clock-rotate-left"></i> {{ $title }}</h4>

            </div>
            <div class="card-body">
              <div class="table-responsive">

                @if ($canExport)
                  <h6 class="text-primary">{!! __('Aksi Ekspor <small>(Client Side)</small>') !!}</h6>
                @endif

                <table class="table table-striped table-hovered" id="datatable" @if ($canExport) data-export="true" data-title="{{ $title }}" @endif>
                  <thead>
                    <tr>
                      <th class="text-center">#</th>
                      <th class="text-center">{{ __('Judul') }}</th>
                      <th class="text-center">{{ __('Jenis') }}</th>
                      <th class="text-center">{{ __('Request Data') }}</th>
                      <th class="text-center">{{ __('Before') }}</th>
                      <th class="text-center">{{ __('After') }}</th>
                      <th class="text-center">{{ __('IP') }}</th>
                      <th class="text-center">{{ __('User Agent') }}</th>
                      <th class="text-center">{{ __('Pengguna') }}</th>
                      <th class="text-center">{{ __('Role') }}</th>
                      <th class="text-center">{{ __('Created At') }}</th>
                      {{-- <th>{{ __('Aksi') }}</th> --}}
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($data as $item)
                      <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->activity_type }}</td>
                        <td>{{ $item->request_data }}</td>
                        <td>{{ $item->before }}</td>
                        <td>{{ $item->after }}</td>
                        <td>{{ $item->ip }}</td>
                        <td>{{ $item->user_agent }}</td>
                        <td>{{ $item->user->name }}</td>
                        <td>{{ $item->role->name ?? '-' }}</td>
                        <td>{{ $item->created_at }}</td>
                        {{-- <td>
                          @if ($canUpdate)
                            @include('stisla.includes.forms.buttons.btn-edit', ['link' => route('student-hahas.edit', [$item->id])])
                          @endif
                          @if ($canDelete)
                            @include('stisla.includes.forms.buttons.btn-delete', ['link' => route('student-hahas.destroy', [$item->id])])
                          @endif
                        </td> --}}
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        @else
          @include('stisla.includes.others.empty-state', [
              'title' => 'Data ' . $title,
              'icon' => 'fa fa-clock-rotate-left',
              'link' => $routeCreate,
              'emptyDesc' => __('Maaf kami tidak dapat menemukan data apa pun'),
          ])
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
@endpush
