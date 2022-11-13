@extends('stisla.layouts.app-table')

@section('title')
  {{ $title = 'Data Role' }}
@endsection

@section('content')
  @include('stisla.includes.breadcrumbs.breadcrumb-table')

  <div class="section-body">
    <h2 class="section-title">{{ $title }}</h2>
    <p class="section-lead">{{ __('Merupakan data jenis pengguna yang diperbolehkan mengakses sistem') }}.</p>
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h4><i class="fa fa-lock"></i> {{ $title }}</h4>

            <div class="card-header-action">
              @if ($canImportExcel)
                @include('stisla.includes.forms.buttons.btn-import-excel')
              @endif

              @if ($canCreate)
                @include('stisla.includes.forms.buttons.btn-add', ['link' => route('user-management.roles.create')])
              @endif
            </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped" id="datatable" @can('Role Ekspor') data-export="true" data-title="{{ __('Role') }}" @endcan>
                <thead>
                  <tr>
                    <th class="text-center">#</th>
                    <th>{{ __('Role') }}</th>
                    <th>{{ __('Aksi') }}</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($data as $item)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>
                        {{ $item->name }}
                      </td>
                      <td>
                        @if ($canUpdate)
                          @if ($item->name === 'superadmin')
                            @include('stisla.includes.forms.buttons.btn-detail', ['link' => route('user-management.roles.edit', [$item->id])])
                          @else
                            @include('stisla.includes.forms.buttons.btn-edit', ['link' => route('user-management.roles.edit', [$item->id])])
                          @endif
                        @endif
                        @if ($canDelete && !$item->is_locked)
                          @include('stisla.includes.forms.buttons.btn-delete', ['link' => route('user-management.roles.destroy', [$item->id])])
                        @endif
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

@if ($canImportExcel)
  @push('modals')
    @include('stisla.includes.modals.modal-import-excel', [
        'formAction' => route('user-management.roles.import-excel'),
        'downloadLink' => route('user-management.roles.import-excel-example'),
        'note' => __('Pastikan nama role tidak ada yang sama'),
    ])
  @endpush
@endif
