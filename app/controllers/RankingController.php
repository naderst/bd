<?php
class RankingController extends BaseController {

    function getIndex() {
        return View::make('ranking.index', array(
            'ranking_nacional' => RankingNacional::join('atletas','ranking_nacional.cedula_atleta','=','atletas.cedula')
                                                   ->orderBy('puntos', 'desc')->paginate(10),

            'ranking_estadal' => RankingEstadal::join('atletas','ranking_estadal.cedula_atleta','=','atletas.cedula')
                                                 ->join('clubes','atletas.codigo_club','=','clubes.codigo')
                                                 ->join('asociaciones','clubes.codigo_asociacion','=','asociaciones.codigo')
                                                 ->orderBy('puntos', 'desc')->paginate(10)
        ));
    }

    function getBuscar() {
        $q = Input::get('q');

        if(trim($q) == '') {
            Session::flash('message', 'No puede realizar una búsqueda vacía');
            Session::flash('message_type', 'error');
            return Redirect::to(Session::get('page.url'));
        }

        return View::make('ranking.index', array(
            'q' => $q,

            'ranking_nacional' => RankingNacional::join('atletas','ranking_nacional.cedula_atleta','=','atletas.cedula')
                                                   ->where('cedula_atleta', 'ILIKE', '%'.$q.'%')
                                                   ->orWhere('nombres', 'ILIKE', '%'.$q.'%')
                                                   ->orWhere('apellidos', 'ILIKE', '%'.$q.'%')
                                                   ->orderBy('puntos', 'desc')->paginate(10),

            'ranking_estadal' => RankingEstadal::join('atletas','ranking_estadal.cedula_atleta','=','atletas.cedula')
                                                   ->join('clubes','atletas.codigo_club','=','clubes.codigo')
                                                   ->join('asociaciones','clubes.codigo_asociacion','=','asociaciones.codigo')
                                                   ->where('cedula_atleta', 'ILIKE', '%'.$q.'%')
                                                   ->orWhere('nombres', 'ILIKE', '%'.$q.'%')
                                                   ->orWhere('apellidos', 'ILIKE', '%'.$q.'%')
                                                   ->orWhere('estado', 'ILIKE', '%'.$q.'%')
                                                   ->orderBy('puntos', 'desc')->paginate(10)
        ));
    }
}
?>
