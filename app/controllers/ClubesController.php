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

	function getIndex() {
		return View::make('clubes.index', array(
			'clubes' => Club::paginate(5)
		));
	}

	function getModificar($codigo) {
		return View::make('clubes.modificar', array(
			'clubes' => Club::find($codigo),
			'asociaciones' => $this->getAsociaciones()
		));
	}

	function postModificar($codigo) {
		$validator = Validator::make(Input::all(), $this->rules);

		if($validator->fails()) {
			return Redirect::action('ClubesController@getModificar', $codigo)->withErrors($validator)->withInput();
		}
		Club::where('codigo', $codigo)->update(Input::except('_token'));
		Session::flash('message', 'Se ha actualizado el club con éxito');

		return $this->redirect2index('/clubes');
	}

	function getAgregar() {
		return View::make('clubes.modificar', array(
			'asociaciones' => $this->getAsociaciones()
		));
	}

	function postAgregar() {
		$validator = Validator::make(Input::all(), $this->rules);

		if($validator->fails()) {
			return Redirect::action('ClubesController@getAgregar')->withErrors($validator)->withInput();
		}

		Club::insert(Input::except('_token'));
		Session::flash('message', 'Se ha agregado el club con éxito');

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
	
		return $this->redirect2index('/clubes');
	}
}
?>