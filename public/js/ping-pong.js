/*  FVTM - UCAB Guayana
    Aplicación: Ping Pong
    Aplicación URL: https://github.com/naderst/bd
    Autores: Nader Abu Fakhr - naderst@gmail.com - @naderst 
             José Cols - josecolsg@gmail.com - @josecols
             Moisés Moussa
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
        return confirm('¿Está seguro que desea eliminar el elemento "' + $('.borrar').attr('data-msg') + '"?');
    });
    $('.save').click(function () {
        $('#frmAsoc').submit();
    });
    $('.saveandreturn').click(function () {
        $('#frmAsoc').attr('action', $('#frmAsoc').attr('action') + '/agregar');
        $('#frmAsoc').submit();
    });

    $('.fecha input[type=text]').datetimepicker({
        lang: 'es',
        timepicker: false,
        format: 'd/m/Y',
    });
});