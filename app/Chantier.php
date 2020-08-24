<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Chantier extends Model
{
    //
	use SoftDeletes;
	
	public function type_chantier()
	{
		$typeChantier = TypeChantier::find($this->type_chantier);
		return ($typeChantier) ? $typeChantier->libelle : '';
	}
	
	public function niveau_validation()
	{
		$typeChantier = TypeChantier::find($this->type_chantier);
		return ($typeChantier) ? $typeChantier->niveau_validation : 0;
	}
	
	public function type_chantier2($societe)
	{
		$typeChantier = DoChantier::where('type_chantier', $this->type_chantier)->where('do', $societe)->first();
		return ($typeChantier) ? $typeChantier->libelle : '';
	}
	
	public function nomDo()
	{
		if($this->do)
		{
			$societe = Societe::find($this->do);
			return $societe->raisonSociale;
		}
		else
		{
			return "Aucun DO principal pour ce chantier";
		}
	}
	public function notifierChangementDate()
	{
		// NOTIFICATION DES COMPTES ACC
		$comptes_acc = Users::where('validation_pieces', 1)->where('societeID', $this->do)->get();
		foreach($comptes_acc as $compte)
		{
			$notification = new Notification();
			$notification->chantier = $this->id;
			$notification->user = $compte->id;
			$notification->message = "Prologation chantier : ".$this->numero."<br>Nouvele date de fin ".$this->date_fin;
			$notification->save();
		}
	}
	
	public function nomTitulaire()
	{
		if($this->societe)
		{
			$societe = Societe::find($this->societe);
			return $societe->raisonSociale;
		}
		else
		{
			return "Aucun titulaire principal pour ce chantier";
		}
	}
	
	public function do()
	{
		$societe = Societe::find($this->do);
		return $societe->raisonSociale;
	}
	
	public function rdv_active()
	{
		$societe = Societe::find($this->do);
		return $societe->rdv_active;
	}
	
	public function equipe($societeID)
	{
		$equipe = Equipier::where('chantier', $this->id)->where('societe', $societeID)->where('categorie', 'intervenant')->get();
		
		return $equipe;
	}
	
	public function icone()
	{
		$type_chantier = TypeChantier::find($this->type_chantier);
		return $type_chantier->icone;
	}
	
	public function statut()
	{
		return "en_cours";
	}
	
	public function titulaires()
	{
		$res = "";
		
		$titulaires = Titulaire::where('chantier', $this->id)->get();
		
		foreach($titulaires as $titulaire)
			$res .= ($titulaire) ? $titulaire->raisonSociale().", " : "";
		
		return substr($res, 0, -2);
	}
	
	public function titulaire_s()
	{
		$res = "";
		
		if($this->societe)
		{
			$titulaire = Societe::find($this->societe);
			$res = $titulaire->raisonSociale;
		}	
		
		$titulaires = Titulaire::where('chantier', $this->id)->get();
		return (count($titulaires) > 1) ? $res." (+".(count($titulaires)-1).")" : $res;
	}
	
	public function titulaire()
	{
		if($this->societe)
		{
			$titulaire = Societe::find($this->societe);
			return $titulaire->raisonSociale;
		}	
		return "N.A";
	}
	
	public function initiateur()
	{
		if($this->initiateur != NULL)
		{
			$initiateur = User::find($this->initiateur);
			return $initiateur->name;
		}
		else
			return "-";
	}
	
	public function pieces_chantier($type_entite = 'intervenant')
	{
		$do = Societe::find($this->do);
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
						if($tp && $tp->chantier)
							$lesPieces[] = $tp;
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
						if($tp && $tp->chantier)
							$lesPieces[] = $tp;
					}
				}
				break;
			case "etranger" :
				$arr = json_decode($do->pieces_etrangers);
		
				$lesPieces = array();
				if($arr != NULL)
				{
					foreach($arr as $ar)
					{
						$tp = TypePiece::find($ar);
						if($tp && $tp->chantier)
							$lesPieces[] = $tp;
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
						if($tp && $tp->chantier)
							$lesPieces[] = $tp;
					}
				}
				break;
		}
		
		return $lesPieces;
	}
			
	public function pieces_oblig($type_entite = 'intervenant')
	{
		$do = Societe::find($this->do);
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
						if($tp)
							$lesPieces[] = $tp;
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
						if($tp)
							$lesPieces[] = $tp;
					}
				}
				break;
			case "etranger" :
				$arr = json_decode($do->pieces_etrangers);
		
				$lesPieces = array();
				if($arr != NULL)
				{
					foreach($arr as $ar)
					{
						$tp = TypePiece::find($ar);
						if($tp)
							$lesPieces[] = $tp;
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
						if($tp)
							$lesPieces[] = $tp;
					}
				}
				break;
		}
		
		return $lesPieces;
	}
	
	public function pieces_immaginables($nature = 'toutes')
	{
		$typePieces = array();
		$do = Societe::find($this->do);
			
		if($nature == 'toutes')
		{
			$pieces_demandees = json_decode($do->pieces_intervenants, true);
			foreach($pieces_demandees as $piece)
			{
				$typePieces[] = TypePiece::find($piece);
	 		}
			
			$pieces_demandees = json_decode($do->pieces_interims, true);
			foreach($pieces_demandees as $piece)
			{
				$typePieces[] = TypePiece::find($piece);
	 		}
			
			$pieces_demandees = json_decode($do->pieces_etrangers, true);
			foreach($pieces_demandees as $piece)
			{
				$typePieces[] = TypePiece::find($piece);
	 		}
		}
		else
		{
			switch($nature)
			{
				case "intervenant" :
					$pieces_demandees = json_decode($do->pieces_intervenants, true);
					break;
				case "interim" :
					$pieces_demandees = json_decode($do->pieces_interims, true);
					break;
				case "etranger" :
					$pieces_demandees = json_decode($do->pieces_etrangers, true);
					break;
			}
		}
		
		foreach($pieces_demandees as $piece)
		{
			$typePieces[] = TypePiece::find($piece);
 		}
		
		return $typePieces;
	}
	
	public function pieces_possibles($type_entite = 'intervenant')
	{
		$do = Societe::find($this->do);
		$lesPieces = array();
		switch($type_entite)
		{
			case "intervenant" :
				$typePieces = TypePiece::where('intervenant', 1)->get();
				$arr = json_decode($do->pieces_intervenants, true);
		
				foreach($typePieces as $tp)
				{
					if(!in_array($tp->id, $arr))
						$lesPieces[] = $tp;
				}
				break;
			case "interim" :
				$typePieces = TypePiece::where('interim', 1)->get();
				$arr = json_decode($do->pieces_interims, true);
		
				foreach($typePieces as $tp)
				{
					if(!in_array($tp->id, $arr))
						$lesPieces[] = $tp;
				}
				break;
			case "etranger" :
				$typePieces = TypePiece::where('etranger', 1)->get();
				$arr = json_decode($do->pieces_etrangers, true);
		
				foreach($typePieces as $tp)
				{
					if(!in_array($tp->id, $arr))
						$lesPieces[] = $tp;
				}
				break;
			case "vehicule" :
				$typePieces = TypePiece::where('vehicule', 1)->get();
				$arr = json_decode($do->pieces_vehicules, true);
	
				foreach($typePieces as $tp)
				{
					if(!in_array($tp->id, $arr))
						$lesPieces[] = $tp;
				}
				break;
		}
		
		return $lesPieces;
	}
}
