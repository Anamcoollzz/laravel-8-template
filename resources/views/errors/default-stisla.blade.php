<section class="section">
  <div class="container mt-5">
    <div class="page-error">
      <div class="page-inner">
        <h1
          @isset($h1FontSize) style="font-size: {{ $h1FontSize }};" @endif>{{ $code ?? 404 }}</h1>
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
      Copyright &copy; {{ since() ?? year() }} <div class="bullet"></div>
      <a href="{{ route('dashboard.index') }}">{{ app_name() }}</a>

      @if (config('app.is_showing_developer'))
        <span> ♥ Aplikasi dibuat oleh {{ developer_name() }}</span>
        <span> ♥ WhatsApp di <a href="https://wa.me/{{ $_whatsapp_developer = whatsapp_developer() }}" target="_blank">{{ $_whatsapp_developer }}</a></span>
      @endif
          </div>
          {{-- @include('stisla.includes.footer') --}}
      </div>
</section>
