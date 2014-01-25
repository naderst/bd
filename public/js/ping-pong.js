/*  FVTM - UCAB Guayana
    Aplicación: Ping Pong
    Aplicación URL: https://github.com/naderst/bd
    Autores: https://github.com/naderst/bd/graphs/contributors
    Version: 1.0
*/


$(document).ready(function () {
    $('#toggler').click(function () {
        $('#aside').slideToggle('fast');
    });
    $('#barra .usuario').click(function () {
        if ($(this).children('i').hasClass('fa-angle-down')) {
            $(this).children('i').removeClass('fa-angle-down');
            $(this).children('i').addClass('fa-angle-up');
        } else {
            $(this).children('i').removeClass('fa-angle-up');
            $(this).children('i').addClass('fa-angle-down');
        }
        $('#usuario').slideToggle('fast');
    });
    $('.borrar').click(function () {
        return confirm('¿Está seguro que desea eliminar el elemento "' + $(this).attr('data-msg') + '"?');
    });
    $('.save').click(function () {
        $('#frmAsoc').submit();
    });
    $('.saveandreturn').click(function () {
        $('#frmAsoc').attr('action', $('#frmAsoc').attr('action') + '/agregar');
        $('#frmAsoc').submit();
    });

    if ($('.fecha input[type=text]').length > 0) {
        $('.fecha input[type=text]').datetimepicker({
            lang: 'es',
            timepicker: false,
            format: 'd/m/Y',
            scrollInput: false
        });
    }
});
