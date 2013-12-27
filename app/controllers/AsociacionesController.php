<?php
class AsociacionesController extends BaseController {
	private $rules = array(
		'nombre' => 'required|min:3',
		'estado' => 'required'
	);

	function getIndex() {
		return View::make('asociaciones.index', array(
			'asociaciones' => Asociacion::all()
		));
	}

	function getModificar($codigo) {
		$result = DB::table('estados')->get();
		$estados = array();

		foreach($result as $e)
			$estados[$e->estado] = $e->estado;

		return View::make('asociaciones.modificar', array(
			'asoc' => DB::table('asociaciones')->where('codigo', $codigo)->first(),
			'estados' => $estados
		));
	}

	function postModificar($codigo) {
		$validator = Validator::make(Input::all(), $this->rules);

		if($validator->fails()) {
			Input::flash();
			return Redirect::action('AsociacionesController@getModificar', $codigo)->withErrors($validator)->withInput();
		}

		DB::table('asociaciones')->where('codigo', $codigo)->update(Input::except('_token'));
		Session::flash('message', 'Se ha actualizado la asociación con éxito');

		return Redirect::action('AsociacionesController@getIndex');
	}

	function getEliminar($codigo) {
		try {
			DB::table('asociaciones')->where('codigo', $codigo)->delete();
		} catch(Exception $exception) {
			Session::flash('message', 'Error eliminando la asociación, el servidor dijo:<br>'.$exception->getMessage());
		}
		
		return Redirect::action('AsociacionesController@getIndex');
	}
}
?>