<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Livraison extends Model
{
    //
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
	
	public function type_livraison2($societe)
	{
		return '';
	}
	
	public function statut()
	{
		return "en_cours";
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
	
	public function do()
	{
		$societe = Societe::find($this->do);
		return $societe->raisonSociale;
	}
	
	public function equipe($societeID)
	{
		$equipe = Livreur::where('livraison', $this->id)->where('societe', $societeID)->where('categorie', 'livreur')->get();
		
		return $equipe;
	}
	
	public function checkPiece($typePieceArg, $societe)
	{
		$typePiece = TypePiece::find($typePieceArg);
		
		$piece = Piece::where('type_piece', $typePieceArg)
			->where('societe', $societe)
			->where('livraison', $this->id)
			->orderBy('created_at', 'desc')->first();
		
		if($piece)
			return ($piece->statut == 'attente') ? 'warning' : 'success'; 
		else
			return 'default';
	}
	
	
	public function pieces_oblig($type_entite = 'intervenant')
	{
		$do = Societe::find($this->do);
		
		switch($type_entite)
		{
			case "livraison" :
				$arr = json_decode($do->pieces_livraisons);
		
				$lesPieces = array();
				if($arr != NULL)
				{
					foreach($arr as $ar)
					{
						$tp = TypePiece::find($ar);
						if($tp->livraison)
							$lesPieces[] = $tp;
					}
				}
				break;
			case "livreur" :
				$arr = json_decode($do->pieces_livreurs);
		
				$lesPieces = array();
				if($arr != NULL)
				{
					foreach($arr as $ar)
					{
						$tp = TypePiece::find($ar);
						if($tp->livreur)
							$lesPieces[] = $tp;
					}
				}
				break;
		}

		return $lesPieces;
	}
	
	public function pieces_immaginables()
	{
		$typePieces = TypePiece::where('livreur', 1)->get();
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
