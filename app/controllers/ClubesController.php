<?php
class ClubesController extends BaseController {
	private $rules = array(
		'nombre' => 'required|min:3',
		'codigo_asociacion' => 'required'
	);

	private function getAsociaciones() {
		$asoc = Asociacion::all();
		$a = array();
		
		foreach($asoc as $e)
			$a[$e->codigo] = $e->nombre;
		
		return $a;
	}

	function getJson() {
		return Club::orderBy('codigo', 'desc')->get(array('clubes.codigo', 'clubes.nombre'));
	}

	function getIndex() {
		return View::make('clubes.index', array(
			'clubes' => Club::orderBy('codigo', 'desc')->paginate(10)
		));
	}

	function getModificar($codigo) {
		return View::make('clubes.modificar', array(
			'clubes' => Club::find($codigo),
			'asociaciones' => $this->getAsociaciones()
		));
	}

	function postModificar($codigo) {
		$validator = Validator::make(Input::all(), $this->rules, $this->messages);

		if($validator->fails()) {
			return Redirect::action('ClubesController@getModificar', $codigo)->withErrors($validator)->withInput();
		}
		Club::where('codigo', $codigo)->update(Input::except('_token'));
		Session::flash('message', 'Se ha actualizado el club con éxito');

		return Redirect::to(Session::get('page.url'));
	}

	function getAgregar() {
		return View::make('clubes.modificar', array(
			'asociaciones' => $this->getAsociaciones()
		));
	}

	function postAgregar($agregar = null) {
		$validator = Validator::make(Input::all(), $this->rules, $this->messages);

		if($validator->fails()) {
			return Redirect::action('ClubesController@getAgregar')->withErrors($validator)->withInput();
		}

		Club::insert(Input::except('_token'));
		Session::flash('message', 'Se ha agregado el club con éxito');

		if($agregar)
			return Redirect::action('ClubesController@getAgregar');
		else
			return Redirect::action('ClubesController@getIndex');
	}

	function getEliminar($codigo) {
		try {
			Club::where('codigo', $codigo)->delete();
			Session::flash('message', 'Se ha eliminado el club con éxito');
		} catch(Exception $exception) {
			Session::flash('message', 'Error eliminando el club, el servidor dijo:<br>'.$exception->getMessage());
			Session::flash('message_type', 'error');
		}
	
		return Redirect::to(Session::get('page.url'));
	}

	function getBuscar() {
		$q = Input::get('q');

		if(trim($q) == '') {
			Session::flash('message', 'No puede realizar una búsqueda vacía');
			Session::flash('message_type', 'error');
			return Redirect::to(Session::get('page.url'));
		}

		return View::make('clubes.index', array(
			'q' => $q,
			'clubes' => Club::where('nombre', 'ILIKE', '%'.$q.'%')->orderBy('codigo', 'desc')->paginate(10)
		));
	}
}
?>