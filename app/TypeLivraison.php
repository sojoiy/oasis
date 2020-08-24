<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeLivraison extends Model
{
    //
	public function getName($societe)
	{
		$doChantier = DoLivraison::where('type_livraison', $this->id)->where('do', $societe)->first();
		return ($doChantier) ? $doChantier->libelle : '';
	}
	
	public function getField($field, $societe)
	{
		$doChantier = DoLivraison::where('type_livraison', $this->id)->where('do', $societe)->first();
		return ($doChantier) ? $doChantier->$field : '';
	}
}
