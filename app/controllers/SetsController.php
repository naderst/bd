<?php
class SetsController extends BaseController {

    function getJson() {
        $cedulaParticipante1 = Input::get('cedula_participante_1');
        $cedulaParticipante2 = Input::get('cedula_participante_2');
        $torneo = Input::get('codigo');
        $fase = Input::get('fase');
        $set = Input::get('set');

        $set = DB::table('sets')->where('cedula_participante_1',$cedulaParticipante1)
                            ->where('cedula_participante_2',$cedulaParticipante2)
                            ->where('codigo_torneo',$torneo)
                            ->where('fase',$fase)
                            ->where('set',$set)->get();

        return $set;
    }
}
?>
