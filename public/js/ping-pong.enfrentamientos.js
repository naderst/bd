/*  FVTM - UCAB Guayana
    Aplicación: Ping Pong
    Aplicación URL: https://github.com/naderst/bd
    Módulo: Torneos
    Autores: https://github.com/naderst/bd/graphs/contributors
    Version: 1.0
*/

var ganadores = [];

function agregarSets(id, contenedor) {
    var setsJugados = parseInt($('input[name=' + id + '-sets_jugados]').val());
    var html = '';

    var cantidad = (setsJugados > 0 ? 2 : 1);

    for (i = 0; i < cantidad; ++i) {
        html += '<tr class="set center" data-id="' + id + '-' + setsJugados + '"><td colspan="2"><b>Set ' + (setsJugados + 1) + '</b></td></tr>' +
            '<tr data-id="' + id + '-' + setsJugados + '"><td>Puntos participante 1:</td>' +
            '<td><input class="puntos" name="' + id + '-' + setsJugados + '-puntos_participante_1" data-participante="participante_1" type="text" value="0"></td></tr>' +
            '<tr data-id="' + id + '-' + setsJugados + '"><td>Puntos participante 2:</td>' +
            '<td><input class="puntos" name="' + id + '-' + setsJugados + '-puntos_participante_2" data-participante="participante_2" type="text" value="0"></td></tr>';
        $('input[name=' + id + '-sets_jugados]').val(++setsJugados);
    }
    contenedor.before(html);
}

function eliminarSets(id) {
    var setsJugados = parseInt($('input[name=' + id + '-sets_jugados]').val());

    var cantidad = (setsJugados == 1 ? 1 : 2);

    for (i = 0; i < cantidad; ++i) {
        $('tr[data-id="' + id + '-' + (setsJugados - 1) + '"]').remove();
        $('input[name=' + id + '-sets_jugados]').val((setsJugados = (setsJugados - 1) < 0 ? 0 : (setsJugados - 1)));
    }
}

function esUltimoSet(id, set) {
    return (set + 1) == parseInt($('input[name="' + id + '-sets_jugados"]').val());
}

function esGanador(id, set, participante) {
    participante = participante.substring(participante.lastIndexOf('_') + 1);
    var oponente = (participante == '1' ? '2' : '1');
    var puntosParticipante = parseInt($('input[name="' + id + '-' + set + '-puntos_participante_' + participante + '"]').val());
    var puntosOponente = parseInt($('input[name="' + id + '-' + set + '-puntos_participante_' + oponente + '"]').val());

    if (puntosParticipante > puntosOponente)
        return true;

    return false;
}

/**
 * El id debe contener el set
 */
function getSet(id) {
    var split = id.split('-');
    return parseInt(split[split.length - 1]);
}

$(document).ready(function () {

    $('.agregar-sets').click(function () {
        agregarSets($(this).attr('data-id'), $(this).parent().parent());
    });

    $('.eliminar-sets').click(function () {
        eliminarSets($(this).attr('data-id'));
    });

    $(document).on('focus', '.puntos', function () {
        $(this).numeric({
            decimal: false,
            negative: false
        }, function () {
            alert("Sólo números positivos");
            this.value = "";
            this.focus();
        });
    });

    $(document).on('change', '.puntos', function () {
        var id = $(this).parent().parent().attr('data-id');
        var participante = $(this).attr('data-participante');
        var oponente = 'participante_' + (participante.substring(participante.lastIndexOf('_') + 1) == '1' ? '2' : '1');
        var set = getSet(id);

        id = id.substring(0, id.lastIndexOf('-'));        

        if (esUltimoSet(id, set) && esGanador(id, set, participante)) {
            ganadores[id] = $('input[name="' + id + '-cedula_' + participante + '"]').val();
        } else if (esUltimoSet(id, set) && esGanador(id, set, oponente)) {
            ganadores[id] = $('input[name="' + id + '-cedula_' + oponente + '"]').val();
        }

        console.log(ganadores);
    });

});