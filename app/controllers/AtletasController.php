<?php
class AtletasController extends BaseController {
	private $rules = array(
		'cedula' => 'required|unique:atletas',
		'nombres' => 'required|min:2',
		'apellidos' => 'required|min:2'
	);

	function getIndex() {		
		return View::make('atletas.index', array(
			'atletas' => Atleta::paginate(5)
		));
	}

	function getAgregar() {
		return "agregar atleta";
	}

	function getModificar($cedula) {
		return Atleta::get($cedula);
	}

	function getEliminar($cedula) {
		try {
			Atleta::destroy($cedula);
			Session::flash('message', 'Se ha eliminado el atleta con éxito');
		} catch(Exception $exception) {
			Session::flash('message', 'Error eliminando el atleta, el servidor dijo:<br>'.$exception->getMessage());
			Session::flash('message_type', 'error');
		}

		return $this->redirect2index('/atletas');
	}
}
?>