@extends('stisla.layouts.app-table')

@section('title')
  {{ $title = 'Data Pengguna' }}
@endsection

@section('content')
  @include('stisla.includes.breadcrumbs.breadcrumb-table')

  <div class="section-body">
    <h2 class="section-title">{{ $title }}</h2>
    <p class="section-lead">{{ __('Merupakan kumpulan data pengguna yang diperbolehkan mengakses sistem') }}.</p>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4><i class="fa fa-users"></i> {{ $title }}</h4>

            <div class="card-header-action">
              @can('Pengguna Impor Excel')
                @include('stisla.includes.forms.buttons.btn-import-excel')
              @endcan

              @can('Pengguna Tambah')
                @include('stisla.includes.forms.buttons.btn-add', ['link'=>route('user-management.users.create')])
              @endcan
            </div>

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
                    @if ($_is_login_must_verified)
                      <th>{{ __('Waktu Verifikasi') }}</th>
                    @endif
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
                      <td>{{ $item->last_login ?? '-' }}</td>
                      @if ($_is_login_must_verified)
                        <td>{{ $item->email_verified_at ?? '-' }}</td>
                      @endif
                      <td>
                        @can('Pengguna Ubah')
                          @include('stisla.includes.forms.buttons.btn-edit', ['link'=>route('user-management.users.edit',
                          [$item->id])])
                        @endcan
                        @can('Pengguna Hapus')
                          @include('stisla.includes.forms.buttons.btn-delete',
                          ['link'=>route('user-management.users.destroy',
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
