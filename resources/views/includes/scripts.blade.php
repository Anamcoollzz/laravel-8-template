<!-- Jquery Core Js -->
<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>

<!-- Bootstrap Core Js -->
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.js') }}"></script>

<!-- Select Plugin Js -->
<script src="{{ asset('assets/plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>

<!-- Slimscroll Plugin Js -->
<script src="{{ asset('assets/plugins/jquery-slimscroll/jquery.slimscroll.js') }}"></script>

<!-- Bootstrap Notify Plugin Js -->
<script src="{{ asset('assets/plugins/bootstrap-notify/bootstrap-notify.js') }}"></script>

<!-- Waves Effect Plugin Js -->
<script src="{{ asset('assets/plugins/node-waves/waves.js') }}"></script>

<!-- Custom Js -->
<script src="{{ asset('assets/js/admin.js') }}"></script>

<!-- Demo Js -->
<script src="{{ asset('assets/js/demo.js') }}"></script>

<script>
  $(function() {
    //Tooltip
    $('[data-toggle="tooltip"]').tooltip({
      container: 'body'
    });

    //Popover
    $('[data-toggle="popover"]').popover();
  })

</script>

@if (session('success_msg'))
  <script>
    function showNotification(colorName, text, placementFrom, placementAlign, animateEnter, animateExit) {
      if (colorName === null || colorName === '') {
        colorName = 'bg-black';
      }
      if (text === null || text === '') {
        text = 'Turning standard Bootstrap alerts';
      }
      if (animateEnter === null || animateEnter === '') {
        animateEnter = 'animated fadeInDown';
      }
      if (animateExit === null || animateExit === '') {
        animateExit = 'animated fadeOutUp';
      }
      var allowDismiss = true;

      $.notify({
        message: text
      }, {
        type: colorName,
        allow_dismiss: allowDismiss,
        newest_on_top: true,
        timer: 1000,
        placement: {
          from: placementFrom,
          align: placementAlign
        },
        animate: {
          enter: animateEnter,
          exit: animateExit
        },
        template: '<div data-notify="container" class="bootstrap-notify-container alert alert-dismissible {0} ' + (
            allowDismiss ? "p-r-35" : "") + '" role="alert">' +
          '<button type="button" aria-hidden="true" class="close" data-notify="dismiss">×</button>' +
          '<span data-notify="icon"></span> ' +
          '<span data-notify="title">{1}</span> ' +
          '<span data-notify="message">{2}</span>' +
          '<div class="progress" data-notify="progressbar">' +
          '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
          '</div>' +
          '<a href="{3}" target="{4}" data-notify="url"></a>' +
          '</div>'
      });
    }

    showNotification('alert-success', '{{ session('success_msg') }}', 'top', 'center', '', '');

  </script>
@endif
