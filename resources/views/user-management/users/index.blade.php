@extends('stisla.layouts.app-table')

@section('title')
  {{ $title = 'Data Pengguna' }}
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
            <h4><i class="fa fa-users"></i> {{ $title }}</h4>

            @can('Pengguna Tambah')
              <div class="card-header-action">
                @include('includes.form.buttons.btn-add', ['link'=>route('user-management.users.create')])
              </div>
            @endcan

          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped" id="datatable">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Email') }}</th>
                    <th>{{ __('Role') }}</th>
                    <th>{{ __('Terakhir Masuk') }}</th>
                    <th>{{ __('Aksi') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($data as $item)

                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $item->name }}</td>
                      <td>{{ $item->email }}</td>
                      <td>
                        @foreach ($item->roles as $role)
                          @if (Auth::user()->can('Role Ubah'))
                            <a href="{{ route('user-management.roles.edit', $role->id) }}">{{ $role->name }}</a>
                          @else
                            {{ $role->name }}
                          @endif
                        @endforeach
                      </td>
                      <td>{{ $item->last_login }}</td>
                      <td>
                        @can('Pengguna Ubah')
                          @include('includes.form.buttons.btn-edit', ['link'=>route('user-management.users.edit',
                          [$item->id])])
                        @endcan
                        @can('Pengguna Hapus')
                          @include('includes.form.buttons.btn-delete', ['link'=>route('user-management.users.destroy',
                          [$item->id])])
                        @endcan
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
