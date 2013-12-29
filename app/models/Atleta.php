<?php
class Atleta extends Eloquent {
	public $timestamps = false;
	public $incrementing = false;
	protected $table = 'atletas';
	protected $primaryKey = 'cedula';

	function club() {
		return $this->belongsTo('Club', 'codigo_club', 'codigo');
	}
}
?>