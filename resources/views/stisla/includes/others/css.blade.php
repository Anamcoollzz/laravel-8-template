<!-- General CSS Files -->
{{-- @if (config('app.is_cdn', false)) --}}
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
  crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-social/4.3.0/bootstrap-social.min.css">
{{-- versi 5 --}}
{{-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous"> --}}
{{-- versi 6 --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

{{-- @else
  <link rel="stylesheet" href="{{ asset('stisla/node_modules/bootstrap/dist/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('stisla/node_modules/bootstrap-social/bootstrap-social.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/font-awesome-5.12/css/all.min.css') }}">
@endif --}}

<!-- CSS Libraries -->
@if (($isAjax ?? false) || ($isAjaxYajra ?? false))
  <link rel="stylesheet" href="{{ asset('plugins/summernote/dist/summernote-bs4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('stisla/node_modules/select2/dist/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('stisla/node_modules/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}">
@endif

@stack('select2_css')
@stack('daterangepicker_css')
@stack('css')

<!-- Template CSS -->
<link rel="stylesheet" href="{{ asset('stisla/assets/css/' . $_skin . '.css') }}">
<link rel="stylesheet" href="{{ asset('stisla/assets/css/components.min.css') }}">
<link rel="stylesheet" href="{{ asset('stisla/assets/css/styleku.min.css') }}">

{{-- <style>
  .modal-backdrop {
    z-index: unset;
  }

</style> --}}
<!-- Your Style -->
@stack('style')
@stack('styles')
