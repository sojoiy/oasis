<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChantierDo extends Model
{
    //
	use SoftDeletes;
	protected $table = 'chantiers_do';
	
	public function type_chantier()
	{
		
	}
	
	public function type_chantier2()
	{
		
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
	
	public function getPiecesNecessaires()
	{
		$typeChantier = TypeChantier::find($this->type_chantier);
		
		$oblig = json_decode($typeChantier->pieces_obligatoires);
		$option = json_decode($typeChantier->pieces_facultatives);
		
		if($option != NULL)
			return array_merge($oblig, $option);
		else
			return $oblig;
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
			
	public function pieces_oblig()
	{
		$typeChantier = TypeChantier::find($this->type_chantier);
		
		$arr = json_decode($typeChantier->pieces_obligatoires);
		
		$lesPieces = array();
		if($arr != NULL)
		{
			foreach($arr as $ar)
			{
				$tp = TypePiece::find($ar);
				$lesPieces[] = $tp;
			}
		}
		
		return $lesPieces;
	}
	
	public function pieces_facultatives()
	{
		$typeChantier = TypeChantier::find($this->type_chantier);
		
		$arr = json_decode($typeChantier->pieces_facultatives);
		
		$lesPieces = array();
		if($arr != NULL)
		{
			foreach($arr as $ar)
			{
				$tp = TypePiece::find($ar);
				$lesPieces[] = $tp;
			}
		}
		
		return $lesPieces;
	}
}
