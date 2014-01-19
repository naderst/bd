<?php
function relacionBinaria($arreglos) {
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


class EnfrentamientosController extends BaseController {

    function getAgregar($codigo) {
        $torneo = Torneo::where('codigo', $codigo)->first();
        
        if ($torneo->cantidad >= 8) {
            $participantes = DB::table('grupos')->where('codigo_torneo', $torneo->codigo)->orderBy('grupo', 'asc')->get();            
            $grupos = array();
            $enfrentamientos = array();
            
            foreach($participantes as $key=>$participante) {                
                $enfrentamientos[$key%4]['cedula'] = $participante->cedula_atleta;
                $enfrentamientos[$key%4]['nombres'] = Atleta::where('cedula', $participante->cedula_atleta)->first()->nombres;
                $enfrentamientos[$key%4]['apellidos'] = Atleta::where('cedula', $participante->cedula_atleta)->first()->apellidos;
                
                if (($key%4) == 3) {
                    $grupos[$participante->grupo] = relacionBinaria(array($enfrentamientos, $enfrentamientos));
                }
            }
            
            $data = array(
                'fases' => array(
                    array(
                        'nombre' => 'Fase de grupos',
                        'grupos' => $grupos
                    )
                ),
                'torneo' => $torneo
            );
        } else {
            $participantes = DB::table('participantes')->where('codigo_torneo', $codigo)->get();
            $enfrentamientos = array();
        
            foreach($participantes as $key=>$participante) {
                $enfrentamientos[$key]['cedula'] = $participante->cedula_atleta;            
                $enfrentamientos[$key]['nombres'] = Atleta::where('cedula', $participante->cedula_atleta)->first()->nombres;
                $enfrentamientos[$key]['apellidos'] = Atleta::where('cedula', $participante->cedula_atleta)->first()->apellidos;
            }
            $enfrentamientos = relacionBinaria(array($enfrentamientos, $enfrentamientos));
            
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
		
//		return $data;
	}

}