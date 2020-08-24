<?php

namespace App;

use App\Societe;
use Illuminate\Database\Eloquent\Model;

class Mandat extends Model
{
    //
	public function getName()
	{
		$mandataire = Societe::find($this->mandataire);
		
		if($mandataire)
			return ($mandataire->temporaire) ? $mandataire->raisonSociale." (AI)" : $mandataire->raisonSociale ;
		
		return "Erreur de mandat";
	}
	
	public function getMandant()
	{
		$mandant = Societe::find($this->societe);
		return $mandant->raisonSociale;
	}
}
