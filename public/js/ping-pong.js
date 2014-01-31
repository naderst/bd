/*  FVTM - UCAB Guayana
    Aplicación: Ping Pong
    Aplicación URL: https://github.com/naderst/bd
    Autores: https://github.com/naderst/bd/graphs/contributors
    Version: 1.0
*/

function agregarCero(n) {
    if (parseInt(n) < 10)
        return '0' + n
    return n;
}

$(document).ready(function () {
    var hoy = new Date();

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

    //    $('.fecha input[type=text]').datetimepicker({
    //        lang: 'es',
    //        timepicker: false,
    //        format: 'd/m/Y',
    //        scrollInput: false
    //    });

    $('.fecha.nacimiento input[type=text]').datetimepicker({
        lang: 'es',
        timepicker: false,
        format: 'd/m/Y',
        scrollInput: false,
        value: agregarCero(hoy.getDate()) + '/' + (agregarCero(hoy.getMonth() + 1)) + '/' + (hoy.getFullYear() - 6),
        maxDate: (hoy.getFullYear() - 6) + '/' + (agregarCero(hoy.getMonth() + 1)) + '/' + agregarCero(hoy.getDate())
    });

});
