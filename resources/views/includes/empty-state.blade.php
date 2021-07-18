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
      <a href="{{ $link }}" class="btn btn-primary mt-4"><i class="fa fa-plus"></i> {{ __('Buat baru') }}</a>
      {{-- <a href="#" class="mt-4 bb">Need Help?</a> --}}
    </div>
  </div>
</div>
