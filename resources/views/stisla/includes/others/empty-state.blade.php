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
        {{-- <i class="fa fa-cloud-exclamation"></i> --}}
      </div>
      <h2>{{ $emptyTitle ?? __('Kami tidak dapat menemukan data apa pun') }}</h2>
      <p class="lead">
        {{ $emptyDesc ??__('Maaf kami tidak dapat menemukan data apa pun, untuk menghilangkan pesan ini, buat setidaknya 1 entri.') }}
      </p>
      <div class=" mt-4">
        @if ($canImportExcel ?? false)
          @include('stisla.includes.forms.buttons.btn-import-excel', ['icon' => 'fa fa-file-excel', 'label' => __('Impor Excel')])
        @endif
        @if ($canCreate ?? false)
          @include('stisla.includes.forms.buttons.btn-primary', ['link' => $link, 'icon' => 'fa fa-plus', 'label' => __('Buat baru')])
        @endif
      </div>
      {{-- <a href="#" class="mt-4 bb">Need Help?</a> --}}
    </div>
  </div>
</div>
