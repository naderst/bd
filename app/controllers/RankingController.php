<?php
class RankingController extends BaseController {

	function getIndex() {
		return View::make('ranking.index', array(
			'ranking_estadal' => RankingEstadal::orderBy('cedula_atleta', 'desc')->paginate(10),
			'ranking_nacional' => RankingNacional::orderBy('cedula_atleta', 'desc')->paginate(10)
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
			'ranking_nacional' => RankingNacional::where('cedula_atleta', 'ILIKE', '%'.$q.'%')->orderBy('cedula_atleta', 'desc')->paginate(10),
			'ranking_estadal' => RankingEstadal::where('cedula_atleta', 'ILIKE', '%'.$q.'%')->orderBy('cedula_atleta', 'desc')->paginate(10)
		));
	}
}
?>