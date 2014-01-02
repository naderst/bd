<?php

class BaseController extends Controller {
	protected $messages = array(
		'required' => 'El campo <b>:attribute</b> es obligatorio',
		'min' => 'El campo <b>:attribute</b> debe tener mínimo :min caracteres',
		'fecha_nacimiento.date_format' => 'La <b>fecha de nacimiento</b> debe tener el formato d/m/a',
		'cedula.unique' => 'La <b>cédula</b> ya existe'
	);
	
	function __construct() {
		if(Session::has('page') && Request::segment(1) != Session::get('page.controller')) {
			Session::forget('page');
		}

		if(!Session::has('page') && Request::segment(2) == 'index' || Request::segment(2) == '') {
			Session::put('page.controller', Request::segment(1));
			Session::put('page.url', URL::full());
		} else if(!Session::has('page')) {
			Session::put('page.controller', Request::segment(1));
			Session::put('page.url', URL::to('/'.Request::segment(1)));
		}
	}

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}
}