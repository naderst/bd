/*  FVTM - UCAB Guayana
    Aplicación: Ping Pong
    Aplicación URL: https://github.com/naderst/bd
    Autores: https://github.com/naderst/bd/graphs/contributors
    Version: 1.0
*/


var usuarioModificado = false;
var claveModificada = false;

function iniciarSesion() {
    $('#login').submit();
}

$(document).ready(function () {
    $('input[type=text]').focusin(function () {
        if (!usuarioModificado) {
            $(this).val('');
        }
    });
    $('input[type=password]').focusin(function () {
        if (!claveModificada) {
            $(this).val('');
        }
    });

    $('input[type=text]').change(function () {
        usuarioModificado = true;
    });
    $('input[type=password]').change(function () {
        claveModificada = true;
    });

    $('#iniciar-sesion').click(function () {
        iniciarSesion();
    });

    $(document).keypress(function (e) {
        if (e.which == 13)
            iniciarSesion();
    });
});