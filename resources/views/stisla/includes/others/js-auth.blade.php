@if (session('successMessage'))
  <input type="hidden" id="sessionSuccessMessage" value="{{ session('successMessage') }}">
@endif

@if (session('errorMessage'))
  <input type="hidden" id="sessionErrorMessage" value="{{ session('errorMessage') }}">
@endif

<!-- General JS Scripts -->
@if (config('app.is_cdn', false))
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
  </script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
  </script>
@else
  <script src="{{ asset('stisla/node_modules/jquery/dist/jquery.min.js') }}"></script>
  <script src="{{ asset('stisla/node_modules/popper.js/dist/umd/popper.min.js') }}"></script>
  <script src="{{ asset('stisla/node_modules/jquery.nicescroll/dist/jquery.nicescroll.min.js') }}"></script>
  <script src="{{ asset('stisla/node_modules/bootstrap/dist/js/bootstrap.min.js') }}"></script>
@endif

<script src="{{ asset('stisla/node_modules/sweetalert/dist/sweetalert.min.js') }}"></script>

<script src="{{ asset('stisla/assets/js/stisla.js') }}"></script>

<!-- JS Tambahan -->
@stack('js')

<!-- Template JS File -->
<script src="{{ asset('stisla/assets/js/scripts.js') }}"></script>
<script src="{{ asset('stisla/assets/js/custom.js') }}"></script>
<script src="{{ asset('stisla/assets/js/my-script.min.js?id=2') }}"></script>

<!-- Your custom script -->

@stack('scripts')

@if (config('app.env') == 'local' && env('LIVERELOAD'))
  <script src="http://localhost:35729/livereload.js"></script>
@endif
