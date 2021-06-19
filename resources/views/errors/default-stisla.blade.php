<section class="section">
  <div class="container mt-5">
    <div class="page-error">
      <div class="page-inner">
        <h1>{{ $code ?? 404 }}</h1>
        <div class="page-description">
          {{ $description ?? __('Halaman yang anda tuju tidak ada') }}
        </div>
        <div class="page-search">
          {{-- <form>
            <div class="form-group floating-addon floating-addon-not-append">
            <div class="input-group">
                <div class="input-group-prepend">
                <div class="input-group-text">
                    <i class="fas fa-search"></i>
                </div>
                </div>
                <input type="text" class="form-control" placeholder="Search">
                <div class="input-group-append">
                <button class="btn btn-primary btn-lg">
                    Search
                </button>
                </div>
            </div>
            </div>
        </form> --}}
          <div class="mt-3">
            <a href="{{ route('dashboard.index') }}">Kembali ke {{ __('Dashboard') }}</a>
          </div>
        </div>
      </div>
    </div>
    <div class="simple-footer mt-5">
      Copyright &copy; {{ session('_year') ?? \App\Models\Setting::where('key', 'year')->first()->value }} <div
        class="bullet"></div>
      <a href="{{ route('dashboard.index') }}">{{ session('_app_name') ?? config('app.name') }}</a>

      @if (config('app.is_showing_developer'))
        <span> ♥ Aplikasi dibuat oleh {{ session('_developer_name') ?? config('app.developer_name') }}</span>
        <span> ♥ WhatsApp di <a
            href="https://wa.me/{{ session('_whatsapp_developer') ?? config('developer.whatsapp') }}"
            target="_blank">{{ session('_whatsapp_developer') ?? config('developer.whatsapp') }}</a></span>
      @endif
    </div>
    {{-- @include('stisla.includes.footer') --}}
  </div>
</section>
