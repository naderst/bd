<?php
class AtletasController extends BaseController {
	private $rules = array(
		'cedula' => 'required|exists:atletas,cedula',
		'nombres' => 'required|min:2',
		'apellidos' => 'required|min2'
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

	}

	function getEliminar($cedula) {

	}
}
?>