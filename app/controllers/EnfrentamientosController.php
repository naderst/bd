<?php
class EnfrentamientosController extends BaseController {

    private static $FASES = array(16 => 'Dieciseisavos de final', 8 => 'Octavos de final', 4 => 'Cuartos de final', 2 => 'Semifinal', 1 => 'Final');
    
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
		
		return $data;
	}

}