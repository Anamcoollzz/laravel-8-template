@extends($data->count() > 0 ?? false ? 'stisla.layouts.app-table' : 'stisla.layouts.app')
{{-- @extends('stisla.layouts.app-table') --}}

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

        @if (!session('dropbox_access_token'))
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
                        'type' => 'text',
                        'id' => 'client_id',
                        'required' => true,
                        'label' => __('Masukkan Client ID'),
                        'value' => request('client_id', ''),
                    ])
                  </div>
                  <div class="col-md-3">
                    @include('stisla.includes.forms.inputs.input', [
                        'type' => 'text',
                        'id' => 'client_secret',
                        'required' => true,
                        'label' => __('Masukkan Client Secret'),
                        'value' => request('client_secret', ''),
                    ])
                  </div>
                  <div class="col-md-3">
                    @include('stisla.includes.forms.inputs.input', [
                        'type' => 'text',
                        'id' => 'code',
                        'required' => true,
                        'label' => __('Masukkan Code'),
                        'value' => request('code'),
                    ])
                  </div>
                  @if ($isSuperAdmin ?? false)
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
                  @endif
                  {{-- @if (count($deviceOptions) > 0)
                  <div class="col-md-3">
                    @include('stisla.includes.forms.selects.select2', [
                        'id' => 'filter_device',
                        'name' => 'filter_device',
                        'label' => __('Pilih Device'),
                        'options' => $deviceOptions,
                        'selected' => request('filter_device'),
                        'with_all' => true,
                    ])
                  </div>
                @endif
                @if (count($platformOptions) > 0)
                  <div class="col-md-3">
                    @include('stisla.includes.forms.selects.select2', [
                        'id' => 'filter_platform',
                        'name' => 'filter_platform',
                        'label' => __('Pilih Platform'),
                        'options' => $platformOptions,
                        'selected' => request('filter_platform'),
                        'with_all' => true,
                    ])
                  </div>
                @endif
                @if (count($browserOptions) > 0)
                  <div class="col-md-3">
                    @include('stisla.includes.forms.selects.select2', [
                        'id' => 'filter_browser',
                        'name' => 'filter_browser',
                        'label' => __('Pilih Browser'),
                        'options' => $browserOptions,
                        'selected' => request('filter_browser'),
                        'with_all' => true,
                    ])
                  </div>
                @endif --}}
                </div>
                <div class="row">
                  <div class="col-12">
                    <a id="linkDropbox" target="_blank"
                      href="https://www.dropbox.com/oauth2/authorize?client_id=jhek37pw269jeaq&token_access_type=offline&response_type=code">https://www.dropbox.com/oauth2/authorize?client_id=jhek37pw269jeaq&token_access_type=offline&response_type=code</a>
                  </div>
                </div>
                <button class="btn btn-primary icon"><i class="fa fa-search"></i> Cari Data</button>
              </form>
            </div>
          </div>
        @else
          <div class="row">
            <div class="col-md-6">
              <div class="card">
                <div class="card-header">
                  <h4><i class="fa fa-upload"></i> Unggah Berkas</h4>
                  <div class="card-header-action">
                  </div>
                </div>
                <div class="card-body">

                  <form action="{{ route('dropboxs.upload') }}?folder={{ request('folder') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                      <div class="col-md-12">
                        @include('stisla.includes.forms.inputs.input', [
                            'type' => 'file',
                            'id' => 'file',
                            'required' => true,
                            'label' => __('Unggah Berkas'),
                        ])
                      </div>
                    </div>
                    <button class="btn btn-primary icon"><i class="fa fa-upload"></i> Unggah</button>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card">
                <div class="card-header">
                  <h4><i class="fa fa-plus"></i> Buat Folder</h4>
                  <div class="card-header-action">
                  </div>
                </div>
                <div class="card-body">

                  <form action="?folder={{ request('folder') }}" method="get">
                    <input type="hidden" name="folder_prefix" value="{{ request('folder') }}">
                    @csrf
                    <div class="row">
                      <div class="col-md-12">
                        @include('stisla.includes.forms.inputs.input', [
                            'type' => 'create_folder',
                            'id' => 'create_folder',
                            'required' => true,
                            'label' => __('Buat Folder'),
                        ])
                      </div>
                    </div>
                    <button class="btn btn-primary icon"><i class="fa fa-plus"></i> Buat</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        @endif


        {{-- @if ($data->count() > 0) --}}
        {{-- @if ($canExport)
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
        @endif --}}

        <div class="card">
          <div class="card-header">
            <h4><i class="fa fa-folder"></i> {{ $title }}</h4>

          </div>
          <div class="card-body">
            <div class="table-responsive">

              {{-- @if ($canExport)
                <h6 class="text-primary">{!! __('Aksi Ekspor <small>(Client Side)</small>') !!}</h6>
              @endif --}}

              <table class="table table-striped table-hovered" id="datatable" {{-- @if ($canExport) data-export="true" data-title="{{ $title }}" @endif --}}>
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    {{-- <th class="text-center">..</th> --}}
                    <th class="text-center">{{ __('.tag') }}</th>
                    <th class="text-center">{{ __('name') }}</th>
                    <th class="text-center">{{ __('path_lower') }}</th>
                    <th class="text-center">{{ __('path_display') }}</th>
                    <th class="text-center">{{ __('id') }}</th>
                    <th>{{ __('Aksi') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($data as $item)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      {{-- <td>
                        @if ($item['.tag'] == 'folder')
                          <a href="?folder={{ encrypt($item['path_lower']) }}">
                            ..
                          </a>
                        @else
                          <a href="?download={{ $item['id'] }}&folder={{ request('folder') }}">
                            ..
                          </a>
                        @endif
                      </td> --}}
                      <td>{{ $item['.tag'] }}</td>
                      <td>{{ $item['name'] }}</td>
                      <td>
                        @if ($item['.tag'] == 'folder')
                          <a href="?folder={{ encrypt($item['path_lower']) }}">
                            {{ $item['path_lower'] }}
                          </a>
                        @else
                          <a href="?download={{ $item['id'] }}&folder={{ request('folder') }}">
                            {{ $item['path_lower'] }}
                          </a>
                        @endif
                      </td>
                      <td>{{ $item['path_display'] }}</td>
                      <td>{{ $item['id'] }}</td>
                      <td>
                        {{-- @if ($canUpdate)
                          @include('stisla.includes.forms.buttons.btn-edit', ['link' => route('student-hahas.edit', [$item->id])])
                        @endif --}}
                        {{-- @if ($canDelete) --}}
                        @include('stisla.includes.forms.buttons.btn-delete', ['link' => route('dropboxs.destroy', ['id' => $item['id']])])
                        {{-- @endif --}}
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
        {{-- @else
          @include('stisla.includes.others.empty-state', [
              'title' => 'Data ' . $title,
              'icon' => 'fa fa-clock-rotate-left',
              'link' => $routeCreate,
              'emptyDesc' => __('Maaf kami tidak dapat menemukan data apa pun'),
          ])
        @endif --}}
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
    $(function() {
      $('#client_id').on('keyup', function(e) {
        var client_id = $(this).val();
        var link = 'https://www.dropbox.com/oauth2/authorize?client_id=' + client_id + '&token_access_type=offline&response_type=code'
        $('#linkDropbox').attr('href', link)
        $('#linkDropbox').text(link)
        // window.open(link, '_blank')
      })
    })
  </script>
@endpush

@push('modals')
@endpush
