<?php

namespace App;

use App\TypePiece;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Piece extends Model
{
	use SoftDeletes;
	
	public function type_piece()
	{
		$mandant = TypePiece::find($this->type_piece);
		
		if($mandant != NULL)
			return $mandant->libelle;
		else
			return "Type inconnu";
	}
	
	public function abbr()
	{
		$tp = TypePiece::find($this->type_piece);
		
		if($tp != NULL)
			return $tp->abbreviation;
		else
			return "Type inconnu";
	}
	
	public function etat()
	{
		switch($this->statut)
		{
			case "attente" :
				return "En attente";
				break;
			case "valide" :
				return "Acceptée";
				break;
			case "refus" :
				return "Refusée";
				break;
		}
		
		return "";
	}
	
	public function nomEntite()
	{
		if($this->entite)
		{
			$entite = Entite::find($this->entite);
			return $entite->name;
		}
		
		return "";
	}
	
    public function numeroChantier()
	{
		if($this->chantier)
		{
			$chantier = Chantier::find($this->chantier);
			return $chantier->numero;
		}
		
		return "";
	}
	
    public function chemin()
	{
		$entite = Entite::find($this->entite);
		return storage_path("pieces/".$entite->societe."/".$this->entite."/pieces/".date('Y', strtotime($this->updated_at))."_".$this->type_piece."/".$this->chemin.".".$this->extension);
	}
}
