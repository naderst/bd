<?php
class Torneo extends Eloquent {
	protected $table = 'torneos';
	protected $primaryKey = 'codigo';
	
	public $timestamps = false;
}
?>