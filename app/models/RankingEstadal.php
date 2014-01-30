<?php
class RankingEstadal extends Eloquent {
	protected $table = 'ranking_estadal';
	protected $primaryKey = 'cedula_atleta';

	public $timestamps = false;

	function atleta() {
		return $this->belongsTo('Atleta', 'cedula_atleta', 'cedula');
	}
}
?>