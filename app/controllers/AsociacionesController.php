<?php
class AsociacionesController extends BaseController {
	private $rules = array(
		'nombre' => 'required|min:3',
		'estado' => 'required'
	);

	private function getEstados() {
		$result = DB::table('estados')->get();
		$estados = array();

		foreach($result as $e)
			$estados[$e->estado] = $e->estado;
		return $estados;
	}

	function getIndex() {
		return View::make('asociaciones.index', array(
			'asociaciones' => Asociacion::all()
		));
	}

	function getAgregar() {
		return View::make('asociaciones.modificar', array(
			'estados' => $this->getEstados()
		));
	}

	function postAgregar() {
		$validator = Validator::make(Input::all(), $this->rules);

		if($validator->fails()) {
			return Redirect::action('AsociacionesController@getAgregar')->withErrors($validator)->withInput();
		}

		DB::table('asociaciones')->insert(Input::except('_token'));
		Session::flash('message', 'Se ha agregado la asociación con éxito');

		return Redirect::action('AsociacionesController@getIndex');
	}

	function getModificar($codigo) {
		return View::make('asociaciones.modificar', array(
			'asoc' => DB::table('asociaciones')->where('codigo', $codigo)->first(),
			'estados' => $this->getEstados()
		));
	}

	function postModificar($codigo) {
		$validator = Validator::make(Input::all(), $this->rules);

		if($validator->fails()) {
			return Redirect::action('AsociacionesController@getModificar', $codigo)->withErrors($validator)->withInput();
		}

		DB::table('asociaciones')->where('codigo', $codigo)->update(Input::except('_token'));
		Session::flash('message', 'Se ha actualizado la asociación con éxito');

		return $this->redirect2index('/asociaciones');
	}

	function getEliminar($codigo) {
		try {
			DB::table('asociaciones')->where('codigo', $codigo)->delete();
			Session::flash('message', 'Se ha eliminado la asociación con éxito');
		} catch(Exception $exception) {
			Session::flash('message', 'Error eliminando la asociación, el servidor dijo:<br>'.$exception->getMessage());
			Session::flash('message_type', 'error');
		}
	
		return $this->redirect2index('/asociaciones');
	}
}
?>