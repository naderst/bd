<?php

class BaseController extends Controller {
	protected $page;
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

	protected function redirect2index($url) {
		if(Session::has('page'))
			$this->page = '?page='.Session::get('page');

		return Redirect::to($url.$this->page);
	}

	function __construct() {
		$this->page = '';

		if(Session::has('page'))
			Session::flash('page', Session::get('page'));

		if(Input::has('page'))
			Session::flash('page', Input::get('page'));
	}
}