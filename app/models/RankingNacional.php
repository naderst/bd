<?php
class RankingNacional extends Eloquent {
	protected $table = 'ranking_nacional';
	protected $primaryKey = 'cedula_atleta';

	public $timestamps = false;

	function atleta() {
		return $this->belongsTo('Atleta', 'cedula_atleta', 'cedula');
	}
}
?>