@if ($isGoogleCaptcha)
  @push('scripts')
    <script>
      $('#formAuth').on('submit', function(e) {
        if (!$('[name="g-recaptcha-response"]').val()) {
          e.preventDefault();
          swal('Gagal', 'Google captcha wajib diisi', 'error');
        }
      });
    </script>
  @endpush
@endif
