<?php
class AtletasController extends BaseController {
	private $rules = array(
		'cedula' => 'required|unique:atletas',
		'nombres' => 'required|min:2',
		'apellidos' => 'required|min:2'
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
		return "agregar atleta";
	}

	function getModificar($cedula) {
		return View::make('atletas.modificar', array(
			'atletas' => Atleta::find($cedula),
			'clubes' => $this->getClubes()
		));
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