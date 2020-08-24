<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Validation extends Model
{
    //
	use SoftDeletes;
	
	public function name()
	{
		$entite = Entite::find($this->entite);
		return $entite->name;
	}
	
	public function societe()
	{
		$entite = Entite::find($this->entite);
		return $entite->societe();
	}
	
	public function etat()
	{
		return $this->etat;
	}
	
	public static function check($do, $intervenant)
	{
		return '';
	}
}
