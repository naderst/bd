<?php
class TorneosController extends BaseController {
	function getIndex() {
		return View::make('torneos.index', array(
			'torneos' => Torneo::orderBy('fecha_inicio', 'desc')->paginate(5)
		));
	}
	
	
    function getBuscar() {
		$q = Input::get('q');

		if(trim($q) == '') {
			Session::flash('message', 'No puede realizar una búsqueda vacía');
			Session::flash('message_type', 'error');
			return Redirect::to(Session::get('page.url'));
		}

		return View::make('torneos.index', array(
			'q' => $q,
			'torneos' => Torneo::where('descripcion', 'ILIKE', '%'.$q.'%')
								->orWhere('fecha_inicio', '=', '%'.(strtotime($q)?strtotime($q):'1800-1-1').'%')
								->orderBy('fecha_inicio', 'desc')
								->paginate(5)
		));
	}
}