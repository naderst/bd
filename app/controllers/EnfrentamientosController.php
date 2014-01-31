<?php
class EnfrentamientosController extends BaseController {

    private static $FASES = array(16 => 'Dieciseisavos de final', 8 => 'Octavos de final', 4 => 'Cuartos de final', 2 => 'Semifinal', 1 => 'Final');
    private static $GRUPOS = 'ABCDEFGHIJKLMNOP';
    private static $ATLETAS_POR_GRUPO = 4;

    private static function relacionBinaria($arreglos) {
        $reflexiva = array();

        while (list($key, $valores) = each($arreglos)) {
            if (empty($reflexiva)) {
                foreach($valores as $valor) {
                    $reflexiva[] = array($key => $valor);
                }
            } else {
                $resultado = array();

                foreach($reflexiva as &$producto) {
                    $producto[$key] = array_shift($valores);
                    $copia = $producto;

                    foreach($valores as $elemento) {
                            $copia[$key] = $elemento;
                            $resultado[] = $copia;
                    }
                }
            }
        }
        return $resultado;
    }

    private static function cardinalidadFactores($n) {
        return log10($n)/log10(2);
    }


    function getAgregar($codigo) {
        $torneo = Torneo::where('codigo', $codigo)->first();

        if ($torneo->cantidad >= 8) {
            $participantes = DB::select('SELECT * FROM f_ver_participantes_grupo('.$torneo->codigo.');');
            $grupos = array();
            $enfrentamientos = array();

            foreach($participantes as $key=>$participante) {
                $enfrentamientos[$key%4] = $participante;

                if (($key%4) == 3) {
                    $grupos[$participante->grupo] = EnfrentamientosController::relacionBinaria(array($enfrentamientos, $enfrentamientos));
                }
            }

            $participantes = DB::select('SELECT * FROM f_ver_participantes('.$torneo->codigo.');');
            $fases = array(array());
            $cantidad = ($torneo->cantidad) / 4;

            for($i = 1; $cantidad >= 1; $cantidad/=2, ++$i) {
                $enfrentamientos = array();
                $fases[$i]['nombre'] = EnfrentamientosController::$FASES[$cantidad];

                for($j = 0; $j < $cantidad; ++$j) {
                    $enfrentamientos[$j] = $participantes;
                }

                $fases[$i]['enfrentamientos'] = $enfrentamientos;
            }

            $fases[0]['nombre'] = 'Fase de grupos';
            $fases[0]['grupos'] = $grupos;

            $data = array(
                'fases' => $fases,
                'torneo' => $torneo
            );
        } else {
            $participantes = DB::select('SELECT * FROM f_ver_participantes('.$torneo->codigo.');');
            $enfrentamientos = array();

            foreach($participantes as $key=>$participante) {
                $enfrentamientos[$key] = $participante;
            }
            $enfrentamientos = EnfrentamientosController::relacionBinaria(array($enfrentamientos, $enfrentamientos));

            $data = array(
                'fases' => array(
                    array(
                        'nombre' => 'Fase de grupos',
                        'enfrentamientos' => $enfrentamientos
                    )
                ),
                'torneo' => $torneo
            );
        }

        return View::make('enfrentamientos.agregar', $data);
    }

    function postAgregar($agregar = null) {
        $torneo = Torneo::where('codigo', Input::get('codigo'))->first();
        $cantidadFases = ($torneo->cantidad < 8 ? 1 : EnfrentamientosController::cardinalidadFactores($torneo->cantidad));
        $cantidadGrupos = $torneo->cantidad / 4;
        $errores = '';
        $existente;

        for ($fase = 0; $fase < $cantidadFases; ++$fase) {

            if ($fase > 0 || $torneo->cantidad < 8)
                $cantidadGrupos = 1;

            for($grupo = 0; $grupo < $cantidadGrupos; ++$grupo) {

                $cantidadEnfrentamientos = ($fase == 0 ? (EnfrentamientosController::$ATLETAS_POR_GRUPO - 1) * 2 : $torneo->cantidad / pow(2, $fase+1));

                for ($enfrentamiento = 0; $enfrentamiento < $cantidadEnfrentamientos; ++$enfrentamiento) {

                    $grupoId = ($fase == 0 && $torneo->cantidad >= 8 ? EnfrentamientosController::$GRUPOS[$grupo].'-' : '');

                    $setsJugados = intval(Input::get($fase.'-'.$grupoId.$enfrentamiento.'-sets_jugados'));
                    $puntosParticipante1 = intval(Input::get($fase.'-'.$grupoId.$enfrentamiento.'-'.($setsJugados - 1).'-puntos_participante_1'));
                    $puntosParticipante2 = intval(Input::get($fase.'-'.$grupoId.$enfrentamiento.'-'.($setsJugados - 1).'-puntos_participante_2'));

                    if ($setsJugados > 0) {

                        if (abs($puntosParticipante1 - $puntosParticipante2) < 2) {
                             $errores = $errores.'<br>'.'No se pudo guardar el enfrentamiento de '.Input::get($fase.'-'.$grupoId.$enfrentamiento.'-cedula_participante_1').' vs '.
                             Input::get($fase.'-'.$grupoId.$enfrentamiento.'-cedula_participante_2').' La diferencia debe ser de <b>2</b> puntos';

                             continue;
                        }

                        $cedulaParticipante1 = Input::get($fase.'-'.$grupoId.$enfrentamiento.'-cedula_participante_1');
                        $cedulaParticipante2 = Input::get($fase.'-'.$grupoId.$enfrentamiento.'-cedula_participante_2');
                        $fecha = Input::get($fase.'-'.$grupoId.$enfrentamiento.'-fecha');

                        $existente = DB::table('enfrentamientos')
                            ->where('cedula_participante_1', $cedulaParticipante1)
                            ->where('cedula_participante_2', $cedulaParticipante2)
                            ->where('codigo_torneo', $torneo->codigo)
                            ->where('fase', $fase)
                            ->first();

                        if (!isset($existente)) {
                            try {
                                DB::table('enfrentamientos')->insert(array(
                                    'cedula_participante_1' => $cedulaParticipante1,
                                    'cedula_participante_2' => $cedulaParticipante2,
                                    'codigo_torneo' => $torneo->codigo,
                                    'fase' => $fase,
                                    'fecha' => $fecha,
                                    'sets_jugados' => $setsJugados
                                ));
                                Session::flash('message', 'Se han agregados los enfrentamientos correctamente');
                            } catch(Exception $exception) {
                                $errores = $errores.'<br>'.$exception->getMessage();
                            }
                        }
                    }

                    for ($set = 0; $set < $setsJugados; ++$set) {
                        $puntosParticipante1 = Input::get($fase.'-'.$grupoId.$enfrentamiento.'-'.$set.'-puntos_participante_1');
                        $puntosParticipante2 = Input::get($fase.'-'.$grupoId.$enfrentamiento.'-'.$set.'-puntos_participante_2');

                        if (!isset($existente)) {
                            try {
                                DB::table('sets')->insert(array(
                                    'cedula_participante_1' => $cedulaParticipante1,
                                    'cedula_participante_2' => $cedulaParticipante2,
                                    'codigo_torneo' => $torneo->codigo,
                                    'fase' => $fase,
                                    'set' => $set,
                                    'puntos_participante_1' => $puntosParticipante1,
                                    'puntos_participante_2' => $puntosParticipante2
                                ));
                            } catch(Exception $exception) {
                                $errores = $errores.'<br>'.$exception->getMessage();
                            }
                        } else {
                            try {
                                DB::table('sets')
                                    ->where('cedula_participante_1', $cedulaParticipante1)
                                    ->where('cedula_participante_2', $cedulaParticipante2)
                                    ->where('codigo_torneo', $torneo->codigo)
                                    ->where('fase', $fase)
                                    ->where('set', $set)
                                    ->update(array(
                                        'puntos_participante_1' => $puntosParticipante1,
                                        'puntos_participante_2' => $puntosParticipante2
                                    )
                                );
                                Session::flash('message', 'Enfrentamientos modificados correctamente');
                            } catch(Exception $exception) {
                                $errores = $errores.'<br>'.$exception->getMessage();
                            }
                        }
                    }
                }
            }
        }

        if ($errores != '') {
            Session::flash('message', 'Error agregando enfrentamientos/sets, el servidor dijo:'.$errores);
            Session::flash('message_type', 'error');
        }

        if ($agregar)
            return Redirect::action('EnfrentamientosController@getAgregar');
        else
            return Redirect::action('TorneosController@getIndex');
    }

    function getJson() {
        $cedulaParticipante1 = Input::get('cedula_participante_1');
        $cedulaParticipante2 = Input::get('cedula_participante_2');
        $torneo = Input::get('codigo');
        $fase = Input::get('fase');

        $enfrentamiento = DB::table('enfrentamientos')->where('cedula_participante_1',$cedulaParticipante1)
                            ->where('cedula_participante_2',$cedulaParticipante2)
                            ->where('codigo_torneo',$torneo)
                            ->where('fase',$fase)->get();

        return $enfrentamiento;
    }

    function getArboles() {
        return View::make('enfrentamientos.arboles', array(
            'torneos' => Torneo::orderBy('fecha_inicio', 'desc')->paginate(10)
        ));
    }

    function getArbol($codigo) {
        $torneo = Torneo::where('codigo', $codigo)->first();

        if ($torneo->cantidad >= 8) {
            $participantes = array();
            $resultados = array();

            $enfrentamientos = DB::table('enfrentamientos')
                ->where('codigo_torneo', $codigo)
                ->where('fase', 1)
                ->orderBy('fecha', 'desc')
                ->get();

            for ($i = 0; $i < count($enfrentamientos); ++$i) {
                $nombres1 = DB::table('atletas')->select('nombres', 'apellidos')->where('cedula', $enfrentamientos[$i]->cedula_participante_1)->get();
                $nombres2 = DB::table('atletas')->select('nombres', 'apellidos')->where('cedula', $enfrentamientos[$i]->cedula_participante_2)->get();
                $participantes[$i] = array(trim(preg_replace('/\s+/', ' ',$nombres1[0]->nombres.' '.$nombres1[0]->apellidos)),
                    trim(preg_replace('/\s+/', ' ',$nombres2[0]->nombres.' '.$nombres2[0]->apellidos)));
            }


            for ($fase = 1; $fase < EnfrentamientosController::cardinalidadFactores($torneo->cantidad); ++$fase) {
                $enfrentamientos = DB::table('enfrentamientos')
                    ->where('codigo_torneo', $codigo)
                    ->where('fase', $fase)
                    ->orderBy('fecha', 'desc')
                    ->get();

                for ($i = 0; $i < count($enfrentamientos); ++$i) {
                    $set =  DB::table('sets')
                        ->where('cedula_participante_1', $enfrentamientos[0]->cedula_participante_1)
                        ->where('cedula_participante_2', $enfrentamientos[0]->cedula_participante_2)
                        ->where('codigo_torneo', $codigo)
                        ->where('fase', $fase)
                        ->where('set', $enfrentamientos[0]->sets_jugados - 1)
                        ->first();

                    $resultados[$fase-1][$i] = array($set->puntos_participante_1, $set->puntos_participante_2);
                }
            }
            return array('teams' => $participantes, 'results' => $resultados);
        }
    }
}
?>
