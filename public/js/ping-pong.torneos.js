/*  FVTM - UCAB Guayana
    Aplicación: Ping Pong
    Aplicación URL: https://github.com/naderst/bd
    Módulo: Torneos
    Autores: Nader Abu Fakhr - naderst@gmail.com - @naderst 
             José Cols - josecolsg@gmail.com - @josecols
             Moisés Moussa
    Version: 1.0
*/

var cantidadParticipantes = 0;
var clubesHTML = '<option value="">Independiente</option>';

function cantidadAgregar(cantidadActual) {
    if (cantidadActual == 64)
        return 0;
    if (cantidadActual == 0)
        return 2;
    else
        return cantidadActual;
}

function agregarParticipantes() {
    var html = '';
    var agregar = cantidadAgregar(cantidadParticipantes);

    for (i = 0; i < agregar; ++i) {
        var indice = (1 + i + cantidadParticipantes);
        html += '<table class="formulario left"><tbody><tr><td>Club:</td><td><select class="club" name="club-' + indice + '" id="' + indice + '">' + clubesHTML +
            '</select></td><td>P' + (indice < 10 ? '0' : '') + indice + ':</td><td><select name="atleta-' + indice + '"></select></td></tr></tbody></table>';
    }
    $('.contenedor').append(html);
    $('.formulario .club').change();

    cantidadParticipantes += agregar;
}

function eliminarParticipantes() {
    var eliminar = ((cantidadParticipantes / 2) == 1 ? 2 : (cantidadParticipantes / 2));
    cantidadParticipantes -= eliminar;
    $('.contenedor table:nth-last-child(-n+' + eliminar + ')').remove();
}

function cargarClubes() {
    $.ajax({
        url: rutaClubes,
        type: 'GET',
        error: function () {
            alert('Ocurrió un error inesperado.');
        },
        success: function (clubes) {
            for (i = 0; i < clubes.length; ++i) {
                clubesHTML += '<option value="' + clubes[i].codigo + '">' + clubes[i].nombre + '</option>';
            }
        }
    });
}

function cargarAtletas(clubID, clubIndice) {
    $.ajax({
        url: rutaAtletas + '/' + clubID,
        type: 'GET',
        error: function () {
            alert('Ocurrió un error inesperado.');
        },
        success: function (atletas) {
            var atletasHTML = '';

            for (i = 0; i < atletas.length; ++i) {
                atletasHTML += '<option value="' + atletas[i].cedula + '">' + atletas[i].nombres + ' ' + atletas[i].apellidos + '</option>';
            }
            $('select[name="atleta-' + clubIndice + '"]').html(atletasHTML);
        }
    });
}

function actualizarCantidad() {
    $('#cantidad').val(cantidadParticipantes);
}

$(document).ready(function () {
    cargarClubes();

    $('#agregar-participante').click(function () {
        agregarParticipantes();
        actualizarCantidad();
    });

    $('#eliminar-participante').click(function () {
        eliminarParticipantes();
        actualizarCantidad();
    });

    $(document).on('change', '.formulario .club', function () {
        cargarAtletas($(this).val(), $(this).attr('id'));
    });

});