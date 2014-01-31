<?php

class BaseController extends Controller {
    protected $messages = array(
        'required' => 'El campo <b>:attribute</b> es obligatorio',
        'min' => 'El campo <b>:attribute</b> debe tener mínimo :min caracteres',
        'max' => 'El campo <b>:attribute</b> debe tener máximo :max caracteres',
        'integer' => 'El campo <b>:attribute</b> debe ser entero',
        'base_dos' => 'El campo <b>:attribute</b> debe ser potencia de dos y menor o igual a 64',
        'edad_minima' => 'La mínima edad permitida es de <b>6</b> años',
        'fecha_nacimiento.date_format' => 'La <b>fecha de nacimiento</b> debe tener el formato d/m/a',
        'cedula.unique' => 'La <b>cédula</b> ya existe',
        'fecha_inicio.date_format' => 'La <b>fecha de incio</b> debe tener el formato d/m/a',
        'fecha_fin.date_format' => 'La <b>fecha de fin</b> debe tener el formato d/m/a'
    );

    function __construct() {
        if(Request::segment(2) == 'index' || Request::segment(2) == '') {
            Session::put('page.controller', Request::segment(1));
            Session::put('page.url', URL::full());
        } elseif(Request::segment(2) == 'buscar') {
            Session::put('page.controller', Request::segment(1));
            Session::put('page.url', URL::full());
        } elseif(!Session::has('page')) {
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
