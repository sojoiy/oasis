<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Autorisation extends Model
{
    use SoftDeletes;
	
	public function identite()
	{
		$entite = Entite::find($this->entite);
		return $entite->name;
	}
	
	public function societe()
	{
		$entite = Entite::find($this->entite);
		return $entite->societe();
	}
	
	public function libelle_statut()
	{
		switch($this->statut)
		{
			case "pending" :
				return "En attente";
				break;
			case "authorized" :
				return "Validée";
				break;
			case "rejected" :
				return "Refusée";
				break;
		}	
	}
	
	public static function check($do, $entite)
	{
		$validation = Autorisation::where('do', $do)->where('entite', $entite)->first();
		
		if($validation)
		{
			if($validation->statut == 'authorized' && $validation->fin_validite >= date('Y-m-d'))
			{
				return "authorized";
			}
			else
			{
				return $validation->statut;
			}
		}
		else
		{
			$entite = Entite::find($entite);
			$entite->checkListeDo($do);
			return "pending";
		}
	}
	
	public function liste_info()
	{
		$this->informations;
	}
	
	public function date_ea()
	{
		if($this->enquete_administrative == 1)
			return date("d/m/Y", strtotime($this->date_ea));
		elseif($this->enquete_administrative == 2)
			return date("d/m/Y", strtotime($this->date_ea));
		
		return "";
	}
	
	public function date_ei()
	{
		if($this->enquete_interne == 1)
			return $this->date_ei;
		elseif($this->enquete_interne == 2)
			return $this->date_ei;
		
		return "";
	}
	
	public function date_ai()
	{
		if($this->avis_interne == 1)
			return $this->date_ai;
		elseif($this->avis_interne == 2)
			return $this->date_ai;
		
		return "";
	}
}
