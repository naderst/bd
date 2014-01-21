/*  FVTM - UCAB Guayana
    Aplicación: Ping Pong
    Aplicación URL: https://github.com/naderst/bd
    Módulo: Torneos
    Autores: https://github.com/naderst/bd/graphs/contributors
    Version: 1.0
*/

const ATLETAS_POR_GRUPO = 4;
const GRUPO_CONTRARIO = {
    'A': 'B',
    'B': 'A',
    'C': 'D',
    'D': 'C',
    'E': 'F',
    'F': 'E',
    'G': 'H',
    'H': 'G',
    'I': 'J',
    'J': 'I',
    'K': 'L',
    'L': 'K',
    'M': 'N',
    'N': 'M',
    'O': 'P',
    'P': 'O'
}
var ganadores = [];

function sortByFrequency(array) {
    var frequency = {};

    array.forEach(function (value) {
        frequency[value] = 0;
    });

    var uniques = array.filter(function (value) {
        return ++frequency[value] == 1;
    });

    return uniques.sort(function (a, b) {
        return frequency[b] - frequency[a];
    });
}

function esImpar(n) {
    return (n % 2) == 1;
}

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

function getFase(id) {
    var split = id.split('-');
    return parseInt(split[0]);
}

function getGrupo(id) {
    var split = id.split('-');
    return split[split.length - 2];
}

function getEnfrentamiento(id) {
    var split = id.split('-');
    return parseInt(split[split.length - 1]);
}

function getSet(id) {
    var split = id.split('-');
    return parseInt(split[split.length - 1]);
}

function getGrupoContrario(id) {
    return GRUPO_CONTRARIO[getGrupo(id)];
}

function esGrupoCerrado(id) {
    var cantidadEnfrentamientos = (ATLETAS_POR_GRUPO - 1) * 2;
    var grupo = getGrupo(id);

    for (i = 0; i < cantidadEnfrentamientos; ++i) {
        var setsJugados = 0;

        if ((setsJugados = parseInt($('input[name="' + '0-' + grupo + '-' + i + '-sets_jugados' + '"]').val())) == 0)
            return false;
        else if ($('input[name="' + '0-' + grupo + '-' + i + '-' + (setsJugados - 1) + '-puntos_participante_1' + '"]').val() == '0' &&
            $('input[name="' + '0-' + grupo + '-' + i + '-' + (setsJugados - 1) + '-puntos_participante_2' + '"]').val() == '0')
            return false;
    }
    return true;
}

function getMejoresGrupo(id) {
    var cantidadEnfrentamientos = (ATLETAS_POR_GRUPO - 1) * 2;
    var grupo = getGrupo(id);
    var ganadoresGrupo = [];

    if (esGrupoCerrado(id)) {
        for (i = 0; i < cantidadEnfrentamientos; ++i)
            ganadoresGrupo[i] = ganadores['0-' + grupo + '-' + i];

        return sortByFrequency(ganadoresGrupo);
    } else {
        return null;
    }
}

function getMejoresGrupoContrario(id) {
    return getMejoresGrupo('0-' + getGrupoContrario(id) + '-0');
}

function getIndiceEnfrentamiento(grupo) {
    return grupo.toUpperCase().charCodeAt(0) - 65;
}

function getProximoEnfrentamiento(enfrentamiento) {
    if (esImpar(enfrentamiento))
        return (enfrentamiento - 1) / 2;
    return enfrentamiento / 2;
}

function planificarEnfrentamientos(id) {
    if (id.split('-')[0] == '0') {
        var grupo = getGrupo(id);
        var grupoContrario = getGrupoContrario(id);
        var mejoresGrupo;
        var mejoresGrupoContrario;

        if ((mejoresGrupo = getMejoresGrupo(id)) != null && (mejoresGrupoContrario = getMejoresGrupoContrario(id)) != null) {
            $('select[name="' + '1-' + getIndiceEnfrentamiento(grupo) + '-cedula_participante_1"]').val(mejoresGrupo[0]);
            $('select[name="' + '1-' + getIndiceEnfrentamiento(grupo) + '-cedula_participante_2"]').val(mejoresGrupoContrario[1]);
            $('select[name="' + '1-' + getIndiceEnfrentamiento(grupoContrario) + '-cedula_participante_1"]').val(mejoresGrupoContrario[0]);
            $('select[name="' + '1-' + getIndiceEnfrentamiento(grupoContrario) + '-cedula_participante_2"]').val(mejoresGrupo[1]);
        } else if (mejoresGrupo == null) {
            $('select[name="' + '1-' + getIndiceEnfrentamiento(grupo) + '-cedula_participante_1"]').val(-1);
            $('select[name="' + '1-' + getIndiceEnfrentamiento(grupoContrario) + '-cedula_participante_2"]').val(-1);
        } else if (mejoresGrupoContrario == null) {
            $('select[name="' + '1-' + getIndiceEnfrentamiento(grupoContrario) + '-cedula_participante_1"]').val(-1);
            $('select[name="' + '1-' + getIndiceEnfrentamiento(grupo) + '-cedula_participante_2"]').val(-1);
        }

        var setGrupo = parseInt($('input[name="1-' + getIndiceEnfrentamiento(grupo) + '-sets_jugados"]').val()) - 1;
        var setGrupoContrario = parseInt($('input[name="1-' + getIndiceEnfrentamiento(grupoContrario) + '-sets_jugados"]').val()) - 1;

        if (setGrupo != -1)
            cambiarPuntos($('.puntos[name="1-' + getIndiceEnfrentamiento(grupo) + '-' + setGrupo + '-puntos_participante_1"]'));

        if (setGrupoContrario != -1)
            cambiarPuntos($('.puntos[name="1-' + getIndiceEnfrentamiento(grupoContrario) + '-' + setGrupoContrario + '-puntos_participante_1"]'));

    } else {
        var fase = getFase(id) + 1;
        var enfrentamiento = getEnfrentamiento(id);
        var proximoEnfrentamiento = getProximoEnfrentamiento(enfrentamiento);


        if (esImpar(enfrentamiento))
            $('select[name="' + fase + '-' + proximoEnfrentamiento + '-cedula_participante_2"]').val(ganadores[id]);
        else
            $('select[name="' + fase + '-' + proximoEnfrentamiento + '-cedula_participante_1"]').val(ganadores[id]);


        var set = parseInt($('input[name="' + fase + '-' + proximoEnfrentamiento + '-sets_jugados"]').val()) - 1;

        if (set != -1) {
            cambiarPuntos($('.puntos[name="' + fase + '-' + proximoEnfrentamiento + '-' + set + '-puntos_participante_1"]'));
        }
    }
}

function cambiarPuntos(campo) {
    var id = campo.parent().parent().attr('data-id');
    var participante = campo.attr('data-participante');
    var oponente = 'participante_' + (participante.substring(participante.lastIndexOf('_') + 1) == '1' ? '2' : '1');
    var fase = getFase(id);
    var set = getSet(id);
    var campo = (fase > 0 ? 'select' : 'input');

    id = id.substring(0, id.lastIndexOf('-'));

    if (esUltimoSet(id, set) && esGanador(id, set, participante)) {
        var cedula = $(campo + '[name="' + id + '-cedula_' + participante + '"]').val();
        ganadores[id] = cedula;
    } else if (esUltimoSet(id, set) && esGanador(id, set, oponente)) {
        var cedula = $(campo + '[name="' + id + '-cedula_' + oponente + '"]').val();
        ganadores[id] = cedula;
    } else if (esUltimoSet(id, set)) {
        ganadores[id] = -1;
    }

    console.log(id + '-' + set);
    console.log(ganadores);
    planificarEnfrentamientos(id);
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

    $('input[name="1-0-cedula_participante_1"]').val(55);

    $(document).on('change', '.puntos', function () {
        cambiarPuntos($(this));
    });

});