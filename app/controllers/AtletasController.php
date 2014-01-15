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
		$a = array('' => 'Independiente');
		
		foreach($clubes as $e)
			$a[$e->codigo] = $e->nombre;
		
		return $a;
	}

	function getJson($codigo_club = null) {
		return Atleta::orderBy('apellidos', 'asc')->where('codigo_club', '=', $codigo_club)->get(array('atletas.cedula', 'atletas.nombres', 'atletas.apellidos'));
	}

	function getIndex() {
		return View::make('atletas.index', array(
			'atletas' => Atleta::orderBy('apellidos', 'asc')->paginate(10)
		));
	}

	function getAgregar() {
		return View::make('atletas.modificar', array(
			'clubes' => $this->getClubes()
		));
	}

	function postAgregar($agregar = null) {
		$validator = Validator::make(Input::all(), $this->rules, $this->messages);

		if($validator->fails()) {
			return Redirect::action('AtletasController@getAgregar')->withErrors($validator)->withInput();
		}

		$input = Input::except('_token');

		if($input['codigo_club'] == '')
			$input['codigo_club'] = null;

		Atleta::insert($input);
		Session::flash('message', 'Se ha agregado el atleta con éxito');

		if($agregar)
			return Redirect::action('AtletasController@getAgregar');
		else
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

		$input = Input::except('_token', 'cedula');

		if($input['codigo_club'] == '')
			$input['codigo_club'] = null;

		Atleta::where('cedula', $cedula)->update($input);
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

	function getBuscar() {
		$q = Input::get('q');

		if(trim($q) == '') {
			Session::flash('message', 'No puede realizar una búsqueda vacía');
			Session::flash('message_type', 'error');
			return Redirect::to(Session::get('page.url'));
		}

		return View::make('atletas.index', array(
			'q' => $q,
			'atletas' => Atleta::where('nombres', 'ILIKE', '%'.$q.'%')
								->orWhere('apellidos', 'ILIKE', '%'.$q.'%')
								->orWhere('cedula', 'ILIKE', '%'.$q.'%')
								->orderBy('apellidos', 'asc')
								->paginate(10)
		));
	}
}
?>