<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delegation extends Model
{
    //
	public function getName()
	{
		$mandataire = Societe::find($this->mandataire);
		return $mandataire->raisonSociale;
	}
	
	public function getMandant()
	{
		$mandant = Societe::find($this->societe);
		return $mandant->raisonSociale;
	}
}
