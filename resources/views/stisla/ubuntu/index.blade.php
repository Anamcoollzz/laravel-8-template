@extends('stisla.layouts.app-table')

@section('title')
  Ubuntu
@endsection

@section('content')
  <div class="section-header">
    <h1>{{ __('Ubuntu') }}</h1>
  </div>
  <div class="row">

    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4><i class="fa fa-folder"></i> {{ __($path) }}</h4>

          @if ($isGit)
            <div class="card-header-action">
              {{-- @include('stisla.includes.forms.buttons.btn-edit', ['link' => route('ubuntu.git-pull', [encrypt($path)]), 'icon' => 'fab fa-github', 'tooltip' => 'git pull origin']) --}}
              @include('stisla.includes.forms.buttons.btn-edit', [
                  'link' => route('ubuntu.set-laravel-permission', [encrypt($path)]),
                  'icon' => 'fab fa-laravel',
                  'tooltip' => 'set laravel permission',
              ])
            </div>
          @endif
        </div>
        <div class="card-body">

          <form action="{{ route('ubuntu.index') }}" method="GET">
            @csrf
            <div class="row">
              <div class="col-md-6">
                @include('stisla.includes.forms.inputs.input', ['required' => true, 'name' => 'redirect_folder', 'label' => 'Path', 'value' => $path])
              </div>
              <div class="col-md-12">
                @include('stisla.includes.forms.buttons.btn-save', ['label' => 'Let\'s Go'])
                <br>
                <br>
                <br>
              </div>
            </div>
          </form>

          <div class="table-responsive">

            <table class="table table-striped table-hovered" id="datatable">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th class="text-center">{{ __('Path') }}</th>
                  <th class="text-center">{{ __('Type') }}</th>
                  <th class="text-center">{{ __('Aksi') }}</th>
                </tr>
              </thead>
              <tbody>
                @php
                  $i = 1;
                @endphp
                @if ($parentPath)
                  <tr>
                    <td>{{ $i++ }}</td>
                    <td>
                      <a href="?folder={{ encrypt($parentPath) }}">
                        ..
                      </a>
                    </td>
                    <td>Dir</td>
                    <td></td>
                  </tr>
                @endif
                @foreach ($foldersWww as $item)
                  <tr>
                    <td>{{ $i++ }}</td>
                    <td>
                      <a href="?folder={{ encrypt($item) }}">
                        {{ $item }}
                      </a>
                    </td>
                    <td>Dir</td>
                    <td></td>
                  </tr>
                @endforeach
                @foreach ($filesWww as $item)
                  <tr>
                    <td>{{ $i++ }}</td>
                    <td>
                      <a target="_blank" href="?download={{ encrypt($item->getPathname()) }}">
                        {{ $item->getPathname() }}
                      </a>
                    </td>
                    <td>File</td>
                    <td>
                      @include('stisla.includes.forms.buttons.btn-edit', ['link' => route('ubuntu.edit', [encrypt($item->getPathname())])])
                      @include('stisla.includes.forms.buttons.btn-edit', [
                          'link' => route('ubuntu.duplicate', [encrypt($item->getPathname())]),
                          'icon' => 'fa fa-copy',
                          'tooltip' => 'Duplikasi',
                      ])
                      @include('stisla.includes.forms.buttons.btn-delete', ['link' => route('ubuntu.destroy', [encrypt($item->getPathname())])])
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>


    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4><i class="fa-brands fa-php"></i> {{ __('Supervisor') }}</h4>
          <div class="card-header-action">
            @include('stisla.includes.forms.buttons.btn-primary', ['link' => route('ubuntu.php-fpm', ['version' => 1, 'action' => 'start']), 'label' => 'Start Supervisor'])
            @include('stisla.includes.forms.buttons.btn-primary', ['link' => route('ubuntu.php-fpm', ['version' => 1, 'action' => 'stop']), 'label' => 'Stop Supervisor'])
            @include('stisla.includes.forms.buttons.btn-primary', [
                'link' => route('ubuntu.php-fpm', ['version' => 1, 'action' => 'restart']),
                'label' => 'Restart Supervisor',
            ])
          </div>
        </div>
        <div class="card-body">
          <pre>{{ $supervisorStatus }}</pre>
          <div class="table-responsive">

            <table class="table table-striped table-hovered" id="datatable">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th class="text-center">{{ __('Path') }}</th>
                  <th class="text-center">{{ __('Type') }}</th>
                  <th class="text-center">{{ __('Aksi') }}</th>
                </tr>
              </thead>
              <tbody>
                @php
                  $i = 1;
                @endphp
                @foreach ($supervisors as $item)
                  <tr>
                    <td>{{ $i++ }}</td>
                    <td>
                      <a href="?folder={{ encrypt($item) }}">
                        {{ $item }}
                      </a>
                    </td>
                    <td>Dir</td>
                    <td></td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    @foreach ($phps as $php)
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4><i class="fa-brands fa-php"></i> {{ __($php['path']) }}</h4>
            <div class="card-header-action">
              @include('stisla.includes.forms.buttons.btn-primary', ['link' => route('ubuntu.php-fpm', ['version' => $php['version'], 'action' => 'start']), 'label' => 'Start FPM'])
              @include('stisla.includes.forms.buttons.btn-primary', ['link' => route('ubuntu.php-fpm', ['version' => $php['version'], 'action' => 'stop']), 'label' => 'Stop FPM'])
              @include('stisla.includes.forms.buttons.btn-primary', ['link' => route('ubuntu.php-fpm', ['version' => $php['version'], 'action' => 'restart']), 'label' => 'Restart FPM'])
            </div>
          </div>
          <div class="card-body">
            <pre>{{ $php['status_fpm'] }}</pre>
            <div class="table-responsive">

              <table class="table table-striped table-hovered" id="datatable">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">{{ __('Path') }}</th>
                    <th class="text-center">{{ __('Type') }}</th>
                    <th class="text-center">{{ __('Aksi') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @php
                    $i = 1;
                  @endphp
                  @foreach ($php['directories'] as $item)
                    <tr>
                      <td>{{ $i++ }}</td>
                      <td>
                        <a href="?folder={{ encrypt($item) }}">
                          {{ $item }}
                        </a>
                      </td>
                      <td>Dir</td>
                      <td></td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    @endforeach

    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4><i class="fa fa-server"></i> {{ __('Nginx Sites Available') }}</h4>
          <div class="card-header-action">
            @include('stisla.includes.forms.buttons.btn-primary', ['link' => route('ubuntu.nginx', ['nginx' => 'start']), 'label' => 'Start Nginx'])
            @include('stisla.includes.forms.buttons.btn-primary', ['link' => route('ubuntu.nginx', ['nginx' => 'stop']), 'label' => 'Stop Nginx'])
            @include('stisla.includes.forms.buttons.btn-primary', ['link' => route('ubuntu.nginx', ['nginx' => 'restart']), 'label' => 'Restart Nginx'])
          </div>
        </div>
        <div class="card-body">
          <pre>{{ $nginxStatus }}</pre>
          <div class="table-responsive">

            <table class="table table-striped table-hovered" id="datatable">
              <thead>
                <tr>
                  <th class="text-center">#</th>
                  <th class="text-center">{{ __('Filename') }}</th>
                  <th class="text-center">{{ __('Domain') }}</th>
                  <th class="text-center">{{ __('Enabled') }}</th>
                  <th class="text-center">{{ __('Aksi') }}</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($files as $item)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->getFilename() }}</td>
                    <td>
                      <a href="http://{{ $item->domain }}" target="_blank">
                        {{ $item->domain }}
                      </a>
                    </td>
                    <td>
                      @if ($item->enabled)
                        <a href="{{ route('ubuntu.toggle-enabled', [encrypt($item->getPathname()), 'false']) }}" class="btn btn-sm btn-success">true</a>
                      @else
                        <a href="{{ route('ubuntu.toggle-enabled', [encrypt($item->getPathname()), 'true']) }}" class="btn btn-sm btn-danger">false</a>
                      @endif
                    </td>
                    <td>
                      @include('stisla.includes.forms.buttons.btn-edit', ['link' => route('ubuntu.edit', [encrypt($item->getPathname())])])
                      @include('stisla.includes.forms.buttons.btn-edit', [
                          'link' => route('ubuntu.duplicate', [encrypt($item->getPathname())]),
                          'icon' => 'fa fa-copy',
                          'tooltip' => 'Duplikasi',
                      ])
                      @include('stisla.includes.forms.buttons.btn-delete', ['link' => route('ubuntu.destroy', [encrypt($item->getPathname())])])
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    @if (request('database') && request('table'))
      <div class="col-12">

        <div class="section-header">
          <h1>MySQL Database</h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">
              <a href="{{ route('ubuntu.index') }}">{{ __('MySQL') }}</a>
            </div>
            <div class="breadcrumb-item active">
              <a href="{{ route('ubuntu.index', ['database' => request('database')]) }}">{{ request('database') }}</a>
            </div>
            <div class="breadcrumb-item">{{ request('table') }}</div>
          </div>
        </div>

        <div class="card">
          <div class="card-header">
            <h4><i class="fa fa-database"></i> {{ __('MySql Database') }} > {{ request('database') }} > {{ request('table') }}</h4>

          </div>
          <div class="card-body">
            <div class="table-responsive">

              <table class="table table-striped table-hovered datatable">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    @foreach ($structure as $item)
                      <th class="text-center">{{ $item->column }}</th>
                    @endforeach

                    <th class="text-center">{{ __('Aksi') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($rows as $item)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      @foreach ($structure as $column)
                        <td>{{ $item->{$column->column} }}</td>
                      @endforeach
                      <td>
                        @include('stisla.includes.forms.buttons.btn-edit', [
                            'link' => route('ubuntu.edit-row', ['database' => request('database'), 'table' => request('table'), 'id' => $item->id]),
                        ])
                        @include('stisla.includes.forms.buttons.btn-delete', [
                            'link' => route('ubuntu.delete-row', ['database' => request('database'), 'table' => request('table'), 'id' => $item->id]),
                        ])
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    @elseif (request('database'))
      <div class="col-12">
        <div class="section-header">
          <h1>MySQL Database</h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">
              <a href="{{ route('ubuntu.index') }}">{{ __('MySQL') }}</a>
            </div>
            <div class="breadcrumb-item">{{ request('database') }}</div>
          </div>
        </div>

        <div class="card">
          <div class="card-header">
            <h4><i class="fa fa-database"></i> {{ __('MySql Database') }} > {{ request('database') }}</h4>

          </div>
          <div class="card-body">
            <div class="table-responsive">

              <table class="table table-striped table-hovered datatable">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">{{ __('Tabel') }}</th>
                    <th class="text-center">{{ __('Size') }}</th>
                    <th class="text-center">{{ __('Rows') }}</th>
                    <th class="text-center">{{ __('Aksi') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($tables as $item)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $item->table }}</td>
                      <td>{{ $item->size_mb }} Mb</td>
                      <td>{{ $item->total_row }}</td>
                      <td>
                        @include('stisla.includes.forms.buttons.btn-edit', [
                            'link' => route('ubuntu.index', ['database' => request('database'), 'table' => $item->table]),
                            'icon' => 'fa fa-table',
                            'tooltip' => 'Lihat Data',
                        ])
                        @include('stisla.includes.forms.buttons.btn-edit', [
                            'link' => route('ubuntu.index', ['database' => request('database'), 'table' => $item->table, 'action' => 'json']),
                            'icon' => 'fa fa-code',
                            'tooltip' => 'Lihat JSON',
                        ])
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    @else
      <div class="col-12">
        <div class="section-header">
          <h1>MySQL Database</h1>
          <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active">
              <a href="{{ route('ubuntu.index') }}">{{ __('MySQL') }}</a>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header">
            <h4><i class="fa fa-database"></i> {{ __('MySql Database') }}</h4>
          </div>
          <div class="card-body">

            <form action="{{ route('ubuntu.create-db') }}" method="POST">
              @csrf
              <div class="row">
                <div class="col-md-6">
                  @include('stisla.includes.forms.inputs.input', ['required' => true, 'name' => 'database_name', 'label' => 'Nama Database'])
                </div>
                <div class="col-md-12">
                  @include('stisla.includes.forms.buttons.btn-save', ['label' => 'Buat Database Baru'])
                  <br>
                  <br>
                  <br>
                </div>
              </div>
            </form>

            <div class="table-responsive">

              <table class="table table-striped table-hovered datatable">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th class="text-center">{{ __('Database') }}</th>
                    <th class="text-center">{{ __('Tabel') }}</th>
                    <th class="text-center">{{ __('Size') }}</th>
                    <th class="text-center">{{ __('Aksi') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($databases as $item)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $item->database }}</td>
                      <td>{{ $item->total_table }}</td>
                      <td>{{ $item->size_mb }} Mb</td>
                      <td>
                        @include('stisla.includes.forms.buttons.btn-edit', [
                            'link' => route('ubuntu.index', ['database' => $item->database]),
                            'icon' => 'fa fa-table',
                            'tooltip' => 'Lihat Tabel',
                        ])
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    @endif


  </div>
@endsection
