/*  FVTM - UCAB Guayana
    Aplicación: Ping Pong
    Aplicación URL: https://github.com/naderst/bd
    Módulo: Torneos
    Autores: https://github.com/naderst/bd/graphs/contributors
    Version: 1.0
*/
$(document).ready(function () {
    $('.torneo').each(function () {
        var id = $(this).attr('data-id');

        $.ajax({
            url: rutaArbol + '/' + id,
            type: 'GET',
            error: function () {
                alert('Ocurrió un error inesperado.');
            },
            success: function (raw) {
                $('.torneo[data-id="' + id + '"').bracket({
                    init: raw,
                    skipConsolationRound: true
                });

            }
        });
    });
});
