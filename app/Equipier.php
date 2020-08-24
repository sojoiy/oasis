<?php

namespace App;

use App\Entite;
use App\Creneau;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;

class Equipier extends Model
{
    //
	public function copies($chantierID)
	{
		// ON VA VERIFIER LES PIECES NECESSAIRES POUR LE TYPE DU CHANTIER
		
		
		$copies = Copie::where('chantier', $chantierID)->where('entite', $this->intervenant)->get();
		return $copies;
	}
	
	public function numero()
	{
		$chantier = Chantier::find($this->chantier);
		return $chantier->numero;
	}
	
	public function name()
	{
		$entite = Entite::find($this->intervenant);
		return $entite->name;
	}
	
    public function date_creneau()
	{
		if($this->creneau)
		{
			$creneau = Creneau::find($this->creneau);
			return date("d/m/Y à H:i", strtotime($creneau->date_debut));
		}
			
		return "Aucun créneau";
	}
	
    public function chantier()
	{
		$chantier = Chantier::find($this->chantier);
		return $chantier;
	}
	
	public function type_vehicule()
	{
		$entite = Entite::find($this->intervenant);
		return $entite->type_vehicule;
	}
	
	public function chauffeur()
	{
		if($this->chauffeur)
		{
			$entite = Entite::find($this->chauffeur);
			return $entite->name;
		}
		else
		{
			return "Aucun chauffeur désigné";
		}
	}
	
	public function modele()
	{
		$entite = Entite::find($this->intervenant);
		return $entite->modele;
	}
	
	public function marque()
	{
		$entite = Entite::find($this->intervenant);
		return $entite->marque;
	}
	
	public function nature()
	{
		$entite = Entite::find($this->intervenant);
		return $entite->nature;
	}
	
	public function immat()
	{
		$entite = Entite::find($this->intervenant);
		return $entite->immatriculation;
	}
	
	public function employeur()
	{
		$societe = Societe::find($this->societe);
		return $societe->raisonSociale;
	}
	
	public function statut()
	{
		$str = "En attente de validation";
		if($this->validation1)
			$str = "En attente de validation niveau 2";

		if($this->validation)
			$str = ($this->cle) ? "Validé" : "Refusé";
		
		return $str;
	}
	
	public function auteur_validation()
	{
		if($this->validation && $this->auteur_validation)
		{
			$valideur = User::find($this->auteur_validation);
			return $valideur->name;
		}
		else
			return "";
	}
	
	public function info_validation()
	{
		$str = "En attente de validation";
		$valideur = User::find($this->auteur_validation);
		
		if($this->validation)
			$str = date('d/m/Y H:i', strtotime($this->validation))." par ".$valideur->name;
				
		return $str;
	}
	
	public function info_validation1()
	{
		$str = "En attente de validation";
		$valideur = User::find($this->auteur_validation1);
		
		if($this->validation1)
			$str = date('d/m/Y H:i', strtotime($this->validation1))." par ".$valideur->name;
				
		return $str;
	}
	
	public function info_validation2()
	{
		$str = "En attente de validation";
		$valideur = User::find($this->auteur_validation2);
		
		if($this->validation2)
			$str = date('d/m/Y H:i', strtotime($this->validation2))." par ".$valideur->name;
				
		return $str;
	}
	
	public function is_valid($do)
	{
		$isvalid = Validation::check($do, $this->intervenant);
		if($isvalid == '')
			return false;
		else
			return true;
	}
	
	public function validation_globale($do)
	{
		$isvalid = Autorisation::check($do, $this->intervenant);
		return $isvalid;
	}
	
	public function genererDocument()
	{
		$salt = str_random(25);
		return str_replace("\\", "", Hash::make($salt));
	}
	
	public function supprimerDocument()
	{
		
	}
	
	public function complet()
	{
		// ON COMPTE LE NOMBRE DE PIECE OBLIGATOIRE A AVOIR 
		$chantier = Chantier::find($this->chantier);
		$piecesNeeded = $chantier->pieces_oblig($this->categorie, $this->intervenant);
		
		$complet = true;
		foreach($piecesNeeded as $type_piece)
		{
			$piece = 0;
			
			if($piece == 0)
			{
				return false;
			}
		}
		
		return true;
	}
	
	public function checkPiece($chantier, $typePiece)
	{
		$entite = Entite::find($this->intervenant);
		
		return $entite->checkPiece($chantier, $typePiece, $this->categorie);
	}
	
	public function getStatutPiece($typePiece, $do)
	{
		$entite = Entite::find($this->intervenant);
		
		return $entite->getStatutPiece($typePiece, $do);
	}
}