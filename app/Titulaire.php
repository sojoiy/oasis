<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Titulaire extends Model
{
    public function raisonSociale()
	{
		if($this->societe)
		{
			$mandant = Societe::find($this->societe);
			return $mandant->raisonSociale;
		}
		
		return "";
	}
		
    public function noSiret()
	{
		$mandant = Societe::find($this->societe);
		return $mandant->noSiret;
	}
	
    public function adresse()
	{
		$mandant = Societe::find($this->societe);
		return $mandant->adressee;
	}
	
    public function mandats()
	{
		return Mandat::where('societe', $this->societe)->where('chantier', $this->chantier)->get();
	}
	
    public function telephone()
	{
		return "";
	}
	
    public function emailDirigeant()
	{
		return "";
	}
	
    public function autreEmail()
	{
		return "";
	}
}
