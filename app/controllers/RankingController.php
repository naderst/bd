<?php
class RankingController extends BaseController {

	function getIndex() {
		return View::make('ranking.index', array(
			'ranking_estadal' => RankingEstadal::orderBy('puntos', 'desc')->paginate(10),
			'ranking_nacional' => RankingNacional::orderBy('puntos', 'desc')->paginate(10)
		));
	}

	function getBuscar() {
		$q = Input::get('q');

		if(trim($q) == '') {
			Session::flash('message', 'No puede realizar una búsqueda vacía');
			Session::flash('message_type', 'error');
			return Redirect::to(Session::get('page.url'));
		}

		RankingNacional::where('cedula_atleta', 'ILIKE', '%'.$q.'%')
												   ->orWhere('cedula_atleta', 'ILIKE', '%'.$q.'%')
												   // ->orWhere('nombres', 'ILIKE', '%'.$q.'%')
												   // ->orWhere('apellidos', 'ILIKE', '%'.$q.'%')
												   ->orderBy('puntos', 'desc')->paginate(10);


		$queries = DB::getQueryLog();
		$last_query = end($queries);

		return $last_query;

		return View::make('ranking.index', array(
			'q' => $q,
			// 'ranking_nacional' => RankingNacional::where('cedula_atleta', 'ILIKE', '%'.$q.'%')
			// 									   ->orWhere('cedula_atleta', 'ILIKE', '%'.$q.'%')
			// 									   ->orWhere('atletas.nombres', 'ILIKE', '%'.$q.'%')
			// 									   ->orWhere('apellidos', 'ILIKE', '%'.$q.'%')
			// 									   ->orderBy('puntos', 'desc')->paginate(10),
				'ranking_nacional' => DB::table('ranking_nacional')
												   ->join('atletas', )
			'ranking_estadal' => RankingEstadal::where('cedula_atleta', 'ILIKE', '%'.$q.'%')
												   ->orWhere('cedula_atleta', 'ILIKE', '%'.$q.'%')
												   ->orWhere('nombres', 'ILIKE', '%'.$q.'%')
												   ->orWhere('apellidos', 'ILIKE', '%'.$q.'%')
												   ->orWhere('estado', 'ILIKE', '%'.$q.'%')
												   ->orderBy('puntos', 'desc')->paginate(10)
		));
	}
}
?>