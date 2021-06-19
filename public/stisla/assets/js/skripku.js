$(document).ready(function () {

    // check all hak akses
    function checkAll(){
        if($('[data-toggle="checkall"]').length){
            $('[data-toggle="checkall"]').each(function(index, item){
                $(item).on('change', function(){
                    var checkbox = $(item).parent().parent().next().find('input');
                    if(this.checked){
                        checkbox.prop('checked', true);
                    }else{
                        checkbox.prop('checked', false);
                    }
                });
            })
        }
    }

    checkAll();

    if($('[data-toggle="checkallmodul"]').length){
        $('[data-toggle="checkallmodul"]').each(function(index, item){
            $(item).on('change', function(){
                if(this.checked){
                    $('[data-toggle="checkall"]').each(function(index2, item2){
                        $(item2).prop('checked', true);
                    });
                }else{
                    $('[data-toggle="checkall"]').each(function(index2, item2){
                        $(item2).prop('checked', false);
                    });
                }
                $('[data-toggle="checkall"]').trigger('change');
            });
        })
    }

    // summernote
    if($('[data-toggle="summernote"]').length){
        $('[data-toggle="summernote"]').each(function(index, item){
            $(item).summernote({
                height: 500,
            });
        })
    }

    // login page only
    if ($('#sapaan').length > 0) {
        var date = new Date();
        var jam = date.getHours();
        var menit = date.getMinutes();
        var pesan = '';
        if (jam >= 18) {
            if (menit >= 30)
                pesan = 'Selamat Malam';
            else
                pesan = 'Selamat Sore';
        } else if (jam >= 14) {
            pesan = 'Selamat Sore';
        } else if (jam >= 10) {
            pesan = 'Selamat Siang';
        } else if (jam >= 4) {
            pesan = 'Selamat Pagi';
        }
        $('#sapaan').html(pesan);
    }

    // show or hide password
    if ($('#password').length > 0) {
        var tombol_mata = $('#password').parents('.form-group');
        tombol_mata = tombol_mata.find('.ikon2');
        if (tombol_mata.length > 0) {
            tombol_mata.css({
                cursor: 'pointer'
            })
            tombol_mata.on('click', function () {
                if (tombol_mata.find('.fa-eye').length > 0) {
                    tombol_mata.parents('.form-group').find('input').attr('type', 'text');
                    tombol_mata.find('i').removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    tombol_mata.parents('.form-group').find('input').attr('type', 'password');
                    tombol_mata.find('i').addClass('fa-eye').removeClass('fa-eye-slash');
                }
            });

        }
    }

    // datatable
    if ($('#datatable').length > 0) {
        $("#datatable").dataTable({
            "language": {
                "lengthMenu": "Menampilkan _MENU_ baris data per halaman",
                "zeroRecords": "Tidak ada data",
                "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                "infoFiltered": "(filtered from _MAX_ total records)",
                "search": 'Pencarian',
                "paginate": {
                    "previous": "Sebelumnya",
                    "next": "Selanjutnya"
                }
            }
        });
    }

    // select2
    if ($('.select2').length > 0) {
        $(".select2").each(function (index, item) {
            $(item).select2();
        });
    }

    // datepicker 
    if ($('.datepicker').length > 0) {

        $('.datepicker').daterangepicker({
            autoUpdateInput: false, //disable default date
            singleDatePicker: true,
            showDropdowns: true,
        });

        $('.datepicker').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD'));
        });
    }

    // toggle sidebar mini 
    window.sidebar_miniku = function(){
        var WINDOW_WIDTH = $(window).outerWidth();
        if(SIDEBAR_MINI && WINDOW_WIDTH > 1024){
            setTimeout(function(){
                $('[data-toggle="sidebar"]').trigger('click');
            }, 500);
        }
    }

    sidebar_miniku();

});

// delete action
function hapus(e, action_url) {
    e.preventDefault();
    swal({
            title: 'Anda yakin?',
            text: 'Sekali dihapus, data tidak akan kembali lagi!',
            icon: 'warning',
            buttons: true,
            dangerMode: true,
            buttons: {
                cancel: {
                    text: "Batal",
                    value: null,
                    visible: true,
                    className: "",
                    closeModal: true,
                },
                confirm: {
                    text: "Lanjutkan",
                }
            }
        })
        .then(function (willDelete) {
            if (willDelete) {
                $('#form-hapus').attr('action', action_url);
                document.getElementById('form-hapus').submit();
            } else {
                swal('Okay, tidak jadi');
            }
        });
}

function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

// form validation

$('form').find('button[type="submit"]').click(function(e){
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').remove();
    $('.input-group-text').removeClass('border-danger');
    var $button = $(this);
    var $form = $button.closest('form');
    $form.find('[data-toggle="summernote_message"]').empty();
    var $formControl = $form.find('.form-control:not(.note-form-control)');
    var tidakError = true
    $formControl.each(function(index, item){
        if(item.hasAttribute('required') && !item.value){
            tidakError = false
            $(item).addClass('is-invalid');
            var $formGroup = $(item).closest('.form-group');
            $formGroup.find('.input-group-text').addClass('border-danger');
            var $invalidFeedback = $formGroup.find('.invalid-feedback');
            if($invalidFeedback.length <= 0){
                $(item).after('<span class="invalid-feedback"></span>');
            }
            $invalidFeedback = $formGroup.find('.invalid-feedback');
            $invalidFeedback.html($(item).attr('required-message'));
        }
        else if(item.type == 'email'){
            if(!validateEmail(item.value)){
                tidakError = false
                $(item).addClass('is-invalid');
                var $formGroup = $(item).closest('.form-group');
                $formGroup.find('.input-group-text').addClass('border-danger');
                var $invalidFeedback = $formGroup.find('.invalid-feedback');
                if($invalidFeedback.length <= 0){
                    $(item).after('<span class="invalid-feedback"></span>');
                }
                $invalidFeedback = $formGroup.find('.invalid-feedback');
                $invalidFeedback.html($(item).attr('email-message'));
            }
        }
    });
    // summernote
    $summernote = $form.find('[data-toggle="summernote"]');
    if($summernote.length){
        var summernote = $summernote[0];
        if(summernote.hasAttribute('required-message') && $summernote.summernote('code') == '<p><br></p>'){
            $form.find('[data-toggle="summernote_message"]').html($summernote.attr('required-message'));
        }
        $summernote.before().val($summernote.summernote('code'));
        // console.log($summernote.before().val())
    }
    if(!tidakError){
        $('html, body').animate({
            scrollTop: $form.offset().top - 100
        }, 1000);
        errorMsg('Ada yang error pada form, silakan cek kembali!!!')
    }
    // return false;
    return tidakError;
});

// swal message

function errorMsg(msg){
    swal('Error!!!', msg, 'error');
}

function successMsg(msg){
    return swal('Sukses', msg, 'success');
}
