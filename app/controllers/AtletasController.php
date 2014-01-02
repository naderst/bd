<?php
class AtletasController extends BaseController {
	private $rules = array(
		'cedula' => 'required|unique:atletas',
		'nombres' => 'required|min:2',
		'apellidos' => 'required|min:2',
		'fecha_nacimiento' => 'required|date_format:d/m/Y'
	);

	private function getClubes() {
		$clubes = Club::all();
		$a = array();
		
		foreach($clubes as $e)
			$a[$e->codigo] = $e->nombre;
		
		return $a;
	}

	function getIndex() {
		return View::make('atletas.index', array(
			'atletas' => Atleta::orderBy('apellidos', 'asc')->paginate(5)
		));
	}

	function getAgregar() {
		return View::make('atletas.modificar', array(
			'clubes' => $this->getClubes()
		));
	}

	function postAgregar() {
		$validator = Validator::make(Input::all(), $this->rules, $this->messages);

		if($validator->fails()) {
			return Redirect::action('AtletasController@getAgregar')->withErrors($validator)->withInput();
		}

		Atleta::insert(Input::except('_token'));
		Session::flash('message', 'Se ha agregado el atleta con éxito');

		return Redirect::action('AtletasController@getIndex');
	}

	function getModificar($cedula) {
		return View::make('atletas.modificar', array(
			'atletas' => Atleta::find($cedula),
			'clubes' => $this->getClubes()
		));
	}

	function postModificar($cedula) {
		unset($this->rules['cedula']);

		$validator = Validator::make(Input::all(), $this->rules, $this->messages);

		if($validator->fails()) {
			return Redirect::action('AtletasController@getModificar', $cedula)->withErrors($validator)->withInput();
		}

		Atleta::where('cedula', $cedula)->update(Input::except('_token', 'cedula'));
		Session::flash('message', 'Se ha actualizado el atleta con éxito');

		return Redirect::to(Session::get('page.url'));
	}

	function getEliminar($cedula) {
		try {
			Atleta::destroy($cedula);
			Session::flash('message', 'Se ha eliminado el atleta con éxito');
		} catch(Exception $exception) {
			Session::flash('message', 'Error eliminando el atleta, el servidor dijo:<br>'.$exception->getMessage());
			Session::flash('message_type', 'error');
		}

		return Redirect::to(Session::get('page.url'));
	}
}
?>