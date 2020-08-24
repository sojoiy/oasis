<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    //
	public function chantier()
	{
		$chantier = Chantier::find($this->chantier);
		return $chantier->numero;
	}
	
	public function prestataire()
	{
		$prestataire = Societe::find($this->prestataire);
		return $prestataire->raisonSociale;
	}
	
	public function entite()
	{
		$entite = Entite::find($this->entite);
		return $entite->name;
	}
}
