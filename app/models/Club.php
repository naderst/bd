<?php
class Club extends Eloquent {
	public $timestamps = false;
	protected $table = 'clubes';
	protected $primaryKey = 'codigo';

	function asociacion() {
		return $this->belongsTo('Asociacion', 'codigo_asociacion', 'codigo');
	}
}
?>