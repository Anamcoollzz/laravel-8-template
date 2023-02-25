@if ($isDetail)
  <script>
    $(function() {
      if ($('#formAction .form-control').length > 0)
        $('#formAction .form-control').attr('disabled', 'disabled')
      if ($('#formAction .custom-switch-input').length > 0)
        $('#formAction .custom-switch-input').attr('disabled', 'disabled')
      if ($('#formAction .selectgroup-input').length > 0)
        $('#formAction .selectgroup-input').attr('disabled', 'disabled')
      if ($('#formAction .colorinput-input').length > 0)
        $('#formAction .colorinput-input').attr('disabled', 'disabled')
      if ($('#formAction #formAreaButton').length > 0)
        $('#formAction #formAreaButton').hide();
      if ($(".summernote-simple").length > 0)
        $(".summernote-simple").summernote("disable");
      if ($(".summernote").length > 0)
        $(".summernote").summernote("disable");
    });
  </script>
@endif
