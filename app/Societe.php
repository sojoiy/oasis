<?php

namespace App;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Societe extends Model
{
    //
	use SoftDeletes;
	
    public function identifiant()
	{
		$user = User::where('societeID', $this->id)->where('groupe', 'user')->first();
		if($user)
			return $user->email;
		else
			return "Pas de compte";
	}
	
    public function compte()
	{
		$user = User::where('societeID', $this->id)->where('groupe', 'user')->first();
		if($user)
			return $user;
		else
		{
			$user = new User();
			$user->groupe = "user";
			$user->do = 0;
			$user->societeID = $this->id;
			$user->name = ($this->nomDirecteur) ? $this->nomDirecteur : "#NA";
			$mypass = "Password*";
			$user->password = Hash::make($mypass);
			$user->save();
			
			return $user;
		}
	}
	
    public function getNomTypeSemaine($semaine)
	{
		$affectation = Affectation::where('societe', $this->id)->where('semaine', $semaine)->first();
		
		if($affectation)
		{
			$typeSemaine = TypeSemaine::find($affectation->type_semaine);
			return $typeSemaine->libelle;
		}	
		else
			return "Non affectée";
	}
	
    public function getTypeSemaine($semaine)
	{
		$affectation = Affectation::where('societe', $this->id)->where('semaine', $semaine)->first();
		
		if($affectation)
		{
			$typeSemaine = TypeSemaine::find($affectation->type_semaine);
			return $typeSemaine->id;
		}	
		else
			return 0;
	}
	
	public function pieces_oblig($type_entite = 'intervenant', $entite = 0)
	{
		$do = Societe::find($this->id);
		switch($type_entite)
		{
			case "intervenant" :
				$arr = json_decode($do->pieces_intervenants);
		
				$lesPieces = array();
				if($arr != NULL)
				{
					foreach($arr as $ar)
					{
						$tp = TypePiece::find($ar);
						$lesPieces[$tp->id] = $tp;
					}
				}
				break;
			case "interim" :
				$arr = json_decode($do->pieces_interims);
		
				$lesPieces = array();
				if($arr != NULL)
				{
					foreach($arr as $ar)
					{
						$tp = TypePiece::find($ar);
						$lesPieces[$tp->id] = $tp;
					}
				}
				break;
			case "etranger" : // POUR LES ETRANGERS CE SERA LES MEMES PIECES POUR TOUS
				$lesPieces = array();
					
				if($entite <> 0)
				{
					$myEntite = Entite::find($entite);
					
					$detachement = Detachement::where('zone_soc', $myEntite->zone_entreprise)->where('zone_ent', $myEntite->zone_entite)->first();
					if($detachement)
					{
						$types = explode(",", $detachement->pieces);
						foreach($types as $type)
						{
							$tp = TypePiece::where('abbreviation', $type)->first();
							if($tp)
								$lesPieces[$tp->id] = $tp;
						}
					}
				}
				
				break;
			case "vehicule" :
				$arr = json_decode($do->pieces_vehicules);
		
				$lesPieces = array();
				if($arr != NULL)
				{
					foreach($arr as $ar)
					{
						$tp = TypePiece::find($ar);
						$lesPieces[$tp->id] = $tp;
					}
				}
				break;
		}
		
		return $lesPieces;
	}
}
