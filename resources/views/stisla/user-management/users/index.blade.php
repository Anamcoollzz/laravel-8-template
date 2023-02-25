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
              @if ($canImportExcel)
                @include('stisla.includes.forms.buttons.btn-import-excel')
              @endif

              @if ($canCreate)
                @include('stisla.includes.forms.buttons.btn-add', ['link' => route('user-management.users.create')])
              @endif
            </div>

          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped" id="datatable">
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th>{{ __('Nama') }}</th>
                    <th>{{ __('No HP') }}</th>
                    <th>{{ __('Tanggal Lahir') }}</th>
                    <th>{{ __('Alamat') }}</th>
                    <th>{{ __('Email') }}</th>
                    @if ($roleCount > 1)
                      <th>{{ __('Role') }}</th>
                    @endif
                    <th>{{ __('Terakhir Masuk') }}</th>
                    @if ($_is_login_must_verified)
                      <th>{{ __('Waktu Verifikasi') }}</th>
                    @endif
                    @if ($canUpdate || $canDelete || ($canForceLogin && $item->id != auth()->id()))
                      <th>{{ __('Aksi') }}</th>
                    @endif
                  </tr>
                </thead>
                <tbody>
                  @foreach ($data as $item)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $item->name }}</td>
                      <td>{{ $item->phone_number }}</td>
                      <td>{{ $item->birth_date }}</td>
                      <td>{{ $item->address }}</td>
                      <td>
                        <a href="mailto:{{ $item->email }}" target="_blank">
                          {{ $item->email }}
                        </a>
                      </td>
                      @if ($roleCount > 1)
                        <td>
                          @foreach ($item->roles as $role)
                            @if (auth()->user()->can('Role Ubah'))
                              <a class="badge badge-primary mb-1" href="{{ route('user-management.roles.edit', $role->id) }}">{{ $role->name }}</a>
                            @else
                              <span class="badge badge-primary mb-1">{{ $role->name }}</span>
                            @endif
                          @endforeach
                        </td>
                      @endif
                      <td>{{ $item->last_login ?? '-' }}</td>
                      @if ($_is_login_must_verified)
                        <td>{{ $item->email_verified_at ?? '-' }}</td>
                      @endif
                      @if ($canUpdate || $canDelete || ($canForceLogin && $item->id != auth()->id()))
                        <td style="width: 150px;">
                          @if ($canUpdate)
                            @include('stisla.includes.forms.buttons.btn-edit', ['link' => route('user-management.users.edit', [$item->id])])
                          @endif
                          @if ($canDelete)
                            @include('stisla.includes.forms.buttons.btn-delete', ['link' => route('user-management.users.destroy', [$item->id])])
                          @endif
                          @if ($canDelete)
                            @include('stisla.includes.forms.buttons.btn-detail', ['link' => route('user-management.users.show', [$item->id])])
                          @endif
                          @if ($canForceLogin && $item->id != auth()->id())
                            @include('stisla.includes.forms.buttons.btn-success', [
                                'link' => route('user-management.users.force-login', [$item->id]),
                                'icon' => 'fa fa-door-open',
                                'title' => 'Force Login',
                                'size' => 'sm',
                            ])
                          @endif
                        </td>
                      @endif
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
