<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeChantier extends Model
{
	use SoftDeletes;
	
    //
	public function getName($societe)
	{
		$doChantier = DoChantier::where('type_chantier', $this->id)->where('do', $societe)->first();
		return ($doChantier) ? $doChantier->libelle : '';
	}
	
	public function getField($field, $societe)
	{
		$doChantier = DoChantier::where('type_chantier', $this->id)->where('do', $societe)->first();
		return ($doChantier) ? $doChantier->$field : '';
	}
}
