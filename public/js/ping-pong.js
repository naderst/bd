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
});

function borrarItem(msg) {
    return confirm('¿Está seguro que desea eliminar el elemento "' + msg + '"?');
}

function frmSubmit(id) {
    $('#' + id).submit();
}

function frmSubmitAdd(id) {
    var id = '#' + id;

    $(id).attr('action', $(id).attr('action') + '/agregar');
    $(id).submit();
}