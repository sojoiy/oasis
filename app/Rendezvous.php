<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rendezvous extends Model
{
    protected $table = 'rendezvous';
	
	public function nomService()
	{
		if($this->service)
		{
			$service = Service::find($this->service);
			return $service->libelle;
		}
		else
		{
			return "Aucun service";
		}
	}
	
	public function nombre_visiteurs()
	{
		if($this->accompagnateurs != "")
		{
			$accompagnants = json_decode($this->accompagnateurs);
			return (sizeof($accompagnants) > 1) ? "(+".(sizeof($accompagnants)-1)."pers.)" : "";
		}
		else
			return "";
	}
	
	public function nombre_creneaux()
	{
		if($this->creneaux != "")
		{
			$creneaux = json_decode($this->creneaux);
			return (sizeof($creneaux) > 1) ? "(+".(sizeof($creneaux)-1).")" : "";
		}
		else
			return "";
	}
	
	public function validation()
	{
		if($this->validation === 0)
		{
			return "Refusé";
		}
		elseif($this->validation <> 0)
			return "Validé";
		else
			return "En attente";
	}
	
	public function valideurs()
	{
		$str = "";
		if($this->valideur)
		{
			$us = User::find($this->valideur);
			$str .= $us->name;
		}
		
		if($this->valideur2)
		{
			$us = User::find($this->valideur2);
			$str .= " & ".$us->name;
		}
		
		return $str;
	}
	
	public function auteur_validation()
	{
		if($this->validation)
		{
			$user = User::find($this->validation);
			return $user->name;
		}
		else
			return "";
	}
}
