<div class="card">
  <div class="card-header">
    <h4>
      <i class="{{ $icon }}"></i>
      {{ $title }}
    </h4>
  </div>
  <div class="card-body">
    <div class="empty-state" data-height="400">
      <div class="empty-state-icon">
        <i class="fas fa-question"></i>
      </div>
      <h2>{{ __('Kami tidak dapat menemukan data apa pun') }}</h2>
      <p class="lead">
        {{ 'Maaf kami tidak dapat menemukan data apa pun, untuk menghilangkan pesan ini, buat setidaknya 1 entri.' }}
      </p>
      <div class=" mt-4">
        {{-- @can('Contoh CRUD Impor Excel') --}}
        @include('includes.form.buttons.btn-import-excel', ['icon'=>'fa fa-file-excel', 'label'=>'Impor Excel'])
        {{-- @endcan --}}
        {{-- @can('Contoh CRUD Tambah') --}}
        <a href="{{ $link }}" class="btn btn-primary"><i class="fa fa-plus"></i>
          {{ __('Buat baru') }}</a>
        {{-- @can('Contoh CRUD Tambah') --}}
      </div>
      {{-- <a href="#" class="mt-4 bb">Need Help?</a> --}}
    </div>
  </div>
</div>
