<footer class="main-footer">
  <div class="footer-left">
    Copyright &copy; {{ $_since < date('Y') ? $_since . ' - ' . date('Y') : $_since }}
    <div class="bullet"></div>
    <a href="{{ route('dashboard.index') }}">{{ $_app_name }}</a>

    @if (config('app.is_showing_developer'))
      <span> ♥ Aplikasi dibuat oleh {{ $_developer_name }}</span>
      <span> ♥ WhatsApp di <a href="https://wa.me/{{ $_whatsapp_developer }}" target="_blank">{{ $_whatsapp_developer }}</a></span>
    @endif

    @if (config('app.is_demo'))
      <span class="badge badge-primary"> Versi Demo</span>
    @endif

  </div>
  <div class="footer-right">
    Versi {{ $_version ?? config('app.version') }}
  </div>
</footer>
