<?php
class TorneosController extends BaseController {
    private $rules = array(
		'descripcion' => 'required',
		'fecha_inicio' => 'required|date_format:d/m/Y',
		'fecha_fin' => 'required|date_format:d/m/Y',
		'tipo' => 'required|max:1',
		'cantidad' => 'required|integer|base_dos'
	);
	
	function __construct() {	
        Validator::extend('base_dos', function($attribute, $value, $parameters) {
            if ($value <= 64 && ($value & ($value - 1)) == 0)
                return true;            
            return false;
        });
    }
	
	function getIndex() {
		return View::make('torneos.index', array(
			'torneos' => Torneo::orderBy('fecha_inicio', 'desc')->paginate(10)
		));
	}
	
    function getAgregar() {
		return View::make('torneos.agregar', array(
            'tipos' => array(
                'S' => 'Sin ranking', 
                'E' => 'Ranking estadal', 
                'N' => 'Ranking nacional'
                )
            )
        );
	}
	
    function postAgregar($agregar = null) {
		$validator = Validator::make(Input::all(), $this->rules, $this->messages);

		if($validator->fails()) {
			return Redirect::action('TorneosController@getAgregar')->withErrors($validator)->withInput();
		}

		DB::table('torneos')->insert(Input::except('_token'));
		Session::flash('message', 'Se ha agregado el torneo con éxito');

		if ($agregar)
			return Redirect::action('TorneosController@getAgregar');
		else
			return Redirect::action('TorneosController@getIndex');
	}

	
    function getBuscar() {
		$q = Input::get('q');

		if(trim($q) == '') {
			Session::flash('message', 'No puede realizar una búsqueda vacía');
			Session::flash('message_type', 'error');
			return Redirect::to(Session::get('page.url'));
		}

		return View::make('torneos.index', array(
			'q' => $q,
			'torneos' => Torneo::where('descripcion', 'ILIKE', '%'.$q.'%')
								->orWhere('fecha_inicio', '=', ((strtotime(str_replace('/', '-', $q)) === FALSE)?'01/01/1800':$q))
								->orderBy('fecha_inicio', 'desc')
								->paginate(10)
		));
	}
}