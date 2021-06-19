<footer class="main-footer">
  <div class="footer-left">
    Copyright &copy; {{ session('_year') ?? \App\Models\Setting::where('key', 'year')->first()->value }} <div
      class="bullet"></div>
    <a href="{{ route('dashboard.index') }}">{{ session('_app_name') ?? config('app.name') }}</a>

    @if (config('app.is_showing_developer'))
      <span> ♥ Aplikasi dibuat oleh {{ session('_developer_name') ?? config('app.developer_name') }}</span>
      <span> ♥ WhatsApp di <a
          href="https://wa.me/{{ session('_whatsapp_developer') ?? config('developer.whatsapp') }}"
          target="_blank">{{ session('_whatsapp_developer') ?? config('developer.whatsapp') }}</a></span>
    @endif

    @if (config('app.is_demo'))
      <span class="badge badge-primary"> Versi Demo</span>
    @endif

  </div>
  <div class="footer-right">
    Versi {{ session('_version') ?? config('app.version') }}
  </div>
</footer>
