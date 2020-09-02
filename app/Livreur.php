<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Livreur extends Model
{
    //
	
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
	
	public function employeur()
	{
		$societe = Societe::find($this->societe);
		return $societe->raisonSociale;
	}
	
	public function nature()
	{
		$entite = Entite::find($this->intervenant);
		return $entite->nature;
	}
	
	public function complet()
	{
		// ON COMPTE LE NOMBRE DE PIECE OBLIGATOIRE A AVOIR 
		$chantier = Livraison::find($this->livraison);
		$piecesNeeded = $chantier->pieces_oblig($this->categorie);
		
		$complet = true;
		foreach($piecesNeeded as $type_piece)
		{
			$piece = array();
			
			if($type_piece->livraison)
			{
				Piece::where('do', $chantier->do)
					->where('statut', 'valide')
					->where('chantier', $chantier->id)
					->where('type_piece', $type_piece->id)
					->where('entite', $this->intervenant)->first();
			}
			else
			{
				Piece::where('do', $chantier->do)
					->where('statut', 'valide')
					->where('type_piece', $type_piece->id)
					->where('entite', $this->intervenant)->first();
			}
			
			if(count($piece) == 0)
			{
				return false;
			}
		}
		
		return true;
	}
	
	public function checkPiece($chantier, $typePiece)
	{
		$entite = Entite::find($this->intervenant);
		
		return $entite->checkPieceL($chantier, $typePiece);
	}
}
