<?php
class AsociacionesController extends BaseController {
	function getIndex() {
		return View::make('asociaciones.index', array('asociaciones' => Asociacion::all()));
	}
}
?>