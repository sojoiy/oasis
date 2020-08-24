<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entite extends Model
{
    //
	use SoftDeletes;
	
	public function pieces($chantierID)
	{
		$pieces = Piece::where('entite', $this->id)->get();
		return $pieces;
	}
	
	public function profil()
	{
		$str = '<i class="fa fa-building"></i> Zone '.$this->zone_entreprise.'<br>';
		$str .= '<i class="fa fa-user"></i> Zone '.$this->zone_entite;
		
		return $str;
	}
	
	public function checkListeDo($do)
	{
		if(Autorisation::where('entite', $this->id)->where('do', $do)->doesntExist())
		{
			$autorisation = new Autorisation;
			$autorisation->entite = $this->id;
			$autorisation->do = $do;
			$autorisation->save();
		}
	}
	
	public function isPersonnelDetache()
	{
		return false;
	}	
	
	public function isInterimaire()
	{
		return false;
	}	
		
	public function getChamp($label)
	{
		$values = json_decode($this->args);
		
		return $values->$label->value;
	}
	
	public function nomType()
	{
		$type_entite = TypeEntite::find($this->type_entite);
		return $type_entite->libelle;
	}
	
	public function nationalite()
	{
		return ($this->nationalite == "FR") ? "Française" : "Autre";
	}
	
	public function habilitations()
	{
		return "";
	}
	
	public function hasHabilitation($id)
	{
		$has = EntiteHabilitation::where('entite', $this->id)->where('habilitation', $id)->first();
		return ($has) ? true : false;
	}
	
	public function validite($documentID = "")
	{
		return "Document valide";
	}
	
	public function societe()
	{
		if($this->societe)
		{
			$societe = Societe::find($this->societe);
			return $societe->raisonSociale;
		}	
		return "";
	}
	public function telephone_societe()
	{
		if($this->societe)
		{
			$societe = Societe::find($this->societe);
			return $societe->telephone;
		}	
		return "";
	}
	public function pays_societe()
	{
		if($this->societe)
		{
			$societe = Societe::find($this->societe);
			return $societe->pays;
		}	
		return "";
	}
	
	public function getAutorisation($do)
	{
		$autorisation = Autorisation::where('entite', $this->id)->where('do', $do)->first();
		if($autorisation)
		{
			$msg = '';
			switch($autorisation->statut)
			{
				case "authorized" :
					$msg = '<br><i data-container="body" data-toggle="kt-popover" data-placement="bottom" data-content="Autorisé jusqu\'au '.date('d/m/Y', strtotime($autorisation->date_fin_validite)).'" class="fa fa-check-circle"></i>';
					break;
				case "rejected" :
					$msg = '<br><i data-container="body" data-toggle="kt-popover" data-placement="bottom" data-content="Interdit jusqu\'au '.date('d/m/Y', strtotime($autorisation->date_fin_invalidite)).'" class="fa fa-ban"></i>';
					break;
				case "pending" :
					echo '<br><i class="fa fa-hourglass"></i>';
					break;
				case "renew" :
					echo '<br><i class="fa fa-hourglass text-danger" data-container="body" data-toggle="kt-popover" data-placement="bottom" data-content="Autorisation à renouveler" ></i>';
					break;
			}
			
			$msg .= ($autorisation->commentaire != '') ? '&nbsp;<i data-container="body" data-toggle="kt-popover" data-placement="bottom" data-content="'.$autorisation->commentaire.'" class="fa fa-info-circle"></i>' : '';
			
			echo $msg;
		}	
		else
		{
			$myEntity->checkListeDo($chantier->do);
			echo '<br><i class="fa fa-hourglass"></i>';
		}	
	}
	
	public function getRenewState($do)
	{
		$autorisation = Autorisation::where('entite', $this->id)->where('do', $do)->first();
		if($autorisation)
		{
			$msg = '';
			switch($autorisation->statut)
			{
				case "authorized" :
					$msg = '&nbsp;<i onclick="renewAuthorisation('.$autorisation->id.');" class="fa fa-redo"></i>';
					break;
				case "rejected" :
					if(date("Y-m-d") >= $autorisation->date_fin_validite)
						$msg = '&nbsp;<i onclick="renewAuthorisation('.$autorisation->id.');" class="fa fa-redo"></i>';
					else
						$msg = '&nbsp;';
					break;
				case "renew" :
					$msg = '&nbsp;<i onclick="renewAuthorisation('.$autorisation->id.');" class="fa fa-redo"></i>';
					break;
				default :
					break;
			}
			
			echo $autorisation->date_fin_validite.$msg;
		}	
		else
		{
			$myEntity->checkListeDo($chantier->do);
			echo '<br><i class="fa fa-hourglass"></i>';
		}	
	}
	
	// CHARGEMENT DES PIECES COTE CHANTIER
	public function chargerPieces($chantier)
	{
		$lesPieces = Piece::where('entite', $this->id)->where('do', NULL)->where('chantier', NULL)->get();
		$myChantier =  Chantier::find($chantier);
		$do =  Societe::find($myChantier->do);
		
		foreach($lesPieces as $piece)
		{
			$status = $this->checkPiece($chantier, $piece->type_piece);
			if($status != 'success')
	        {	
				$pieceDo = Piece::where('entite', $this->id)->where('do', $myChantier->do)->where('type_piece', $piece->type_piece)->first();
				if($pieceDo)
					$pieceDo->delete();
				
				switch($this->nature)
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
		
				if(in_array($piece->type_piece, $pieces_demandees))
				{
					$myPiece = new Piece;
			        $myPiece->do = $myChantier->do;
			        $myPiece->entite = $this->id;
			        $myPiece->chemin = $piece->chemin;
			        $myPiece->type_piece = $piece->type_piece;
			        $myPiece->date_expiration = $piece->date_expiration;
			        $myPiece->extension = $piece->extension;

			        $myPiece->save();
				}
				else
				{
					// DO NOTHING
				}
	        }
		}
		
		$this->verifier($myChantier->do);
	}
	
	public function chargerPiece($do, $typePiece)
	{
		$piece = Piece::where('entite', $this->id)->where('do', NULL)->where('chantier', NULL)->where('type_piece', $typePiece)->first();
		$pieceDo = Piece::where('entite', $this->id)->where('do', $do)->where('type_piece', $typePiece)->first();
		if($pieceDo)
		{
			$pieceDo->delete();
			
			$myPiece = new Piece;
	        $myPiece->do = $do;
	        $myPiece->entite = $this->id;
	        $myPiece->chemin = $piece->chemin;
	        $myPiece->type_piece = $piece->type_piece;
	        $myPiece->date_expiration = $piece->date_expiration;
	        $myPiece->extension = $piece->extension;

	        $myPiece->save();
		
			$this->verifier($do);
		
			return "Pièce chargée";
		}
		else
		{
			$myPiece = new Piece;
	        $myPiece->do = $do;
	        $myPiece->entite = $this->id;
	        $myPiece->chemin = $piece->chemin;
	        $myPiece->type_piece = $piece->type_piece;
	        $myPiece->date_expiration = $piece->date_expiration;
	        $myPiece->extension = $piece->extension;

	        $myPiece->save();
		
			$this->verifier($do);
		}
		
		return false;
	}
	
	public function checkPiece($chantier, $typePieceArg, $nature = '')
	{
		$typePiece = TypePiece::find($typePieceArg);
		$myChantier = Chantier::find($chantier);
		$do = Societe::find($myChantier->do);
		
		$nature_arg = ($nature != '') ? $nature : $this->nature;
		switch($nature_arg)
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
		
		if(!in_array($typePieceArg, $pieces_demandees))
			return '';
		
		if($typePiece->chantier)
		{
			$piece = Piece::where('type_piece', $typePieceArg)
				->where('entite', $this->id)
				->where('chantier', $chantier)
				->orderBy('created_at', 'desc')->first();
			
			if($piece)
			{
				switch($piece->statut)
				{
					case "attente" :
						return 'warning';
						break;
					case "valide" :
						return 'success';
						break;
					default : 
						return 'danger';
						break;
				}
			}
			else
				return 'default';
		}
		else
		{
			$mychantier = Chantier::find($chantier);
			
			$piece = Piece::where('type_piece', $typePieceArg)
				->where('entite', $this->id)
				->where('do', $mychantier->do)
				->orderBy('created_at', 'desc')->first();
			
			if($piece)
			{
				switch($piece->statut)
				{
					case "attente" :
						return 'warning';
						break;
					case "valide" :
						return 'success';
						break;
					default : 
						return 'danger';
						break;
				}
			}
			else
				return 'default';
		}
		
		return 'default';
	}
	
	public function checkMyPiece($typePiece, $do = NULL)
	{
		$piece = Piece::where('type_piece', $typePiece)
			->where('entite', $this->id)
			->where('do', $do)
			->where('chantier', NULL)
			->orderBy('created_at', 'desc')->first();
		
		if($piece)
		{
			if($piece->date_expiration < date("Y-m-d"))
				return date("d/m/Y", strtotime($piece->date_expiration));
			
			if($do == NULL)
				return date("d/m/Y", strtotime($piece->date_expiration));
			else
			{
				if($piece->statut == 'attente')
					return 'Traitement en cours';
				else
				{
					if($piece->statut == "valide")
						return date("d/m/Y", strtotime($piece->date_expiration));
					elseif($piece->statut == "refus")
						return date("d/m/Y", strtotime($piece->date_expiration));
					else
						return date("d/m/Y", strtotime($piece->date_expiration));
				} 
			}
		}
		
		return false;
	}
	
	public function expMyPiece($typePiece, $do = NULL)
	{
		$piece = Piece::where('type_piece', $typePiece)
			->where('entite', $this->id)
			->where('do', $do)
			->where('chantier', NULL)
			->orderBy('created_at', 'desc')->first();
		
		if($piece)
		{
			if($do == NULL)
				return $piece->date_expiration >= date("Y-m-d");
			else
			{
				return $piece->date_expiration >= date("Y-m-d"); 
			}
		}
		
		return false;
	}
	
	public function getMyPiece($typePiece, $do = NULL)
	{
		$piece = Piece::where('type_piece', $typePiece)
			->where('entite', $this->id)
			->where('do', $do)
			->where('chantier', NULL)
			->orderBy('created_at', 'desc')->first();
		
		if($piece)
		{
			return $piece->id;
		}
		
		return false;
	}
	
	public function getStatutPiece($typePiece, $do = NULL)
	{
		$piece = Piece::where('type_piece', $typePiece)
			->where('entite', $this->id)
			->where('do', $do)
			->where('chantier', NULL)
			->orderBy('created_at', 'desc')->first();
		
		if($piece)
		{
			return $piece->statut;
		}
		
		return "";
	}
	
	public function getCommentairePiece($typePiece, $do = NULL)
	{
		$piece = Piece::where('type_piece', $typePiece)
			->where('entite', $this->id)
			->where('do', $do)
			->where('chantier', NULL)
			->orderBy('created_at', 'desc')->first();
		
		if($piece)
		{
			return $piece->commentaire;
		}
		
		return "";
	}
	
	public function verifier($do)
	{
		// ON VA VERIFIER TOUS LES CHANTIER DU GARS
		$equipiers = Equipier::where('intervenant', $this->id)->where('do', $do)->get();
		
		foreach($equipiers as $equipier)
		{
			// SI ON A DEJA NOTIFIE LE VALIDEUR QUE LE DOSSIER ETAIT COMPLET ON NE FAIT RIEN
			if(!$equipier->notifie)
			{
				if($equipier->complet())
				{	
					$chantier = Chantier::find($equipier->chantier);
					$societe = Societe::find($chantier->do);
				
					// ON VERIFIE LE CAS DU CHANTIER
					$typeChantier = DoChantier::find($chantier->type_chantier);
					$intervenant = Entite::find($this->id);
				
					switch($chantier->mecanisme)
					{
						// DANS UN CAS 1 OU 2 ON NE FAIT RIEN ET L'INTERVENANT EST VALIDE
						case 1 :
						case 2 :
							// NOTIFICATION DU DO
							$notification = new Notification();
							$notification->chantier = $this->chantier;
							$notification->entite = $this->intervenant;
							$notification->prestataire = $chantier->do;
							$notification->message = $chantier->numero." // ".$intervenant->name." validé";
							$notification->save();
			
							// NOTIFICATION DU PRESTATAIRE
							$notification = new Notification();
							$notification->chantier = $this->chantier;
							$notification->entite = $this->intervenant;
							$notification->prestataire = $this->societe;;
							$notification->message = $chantier->numero." // ".$intervenant->name." validé";
							$notification->save();
						
							$equipier->validation = time();
							$equipier->auteur_validation = 0;
							$equipier->notifie = 1;
							$equipier->save();
							break;
						case 3 :
						case 4 :
							// NOTIFICATION DU DO
							$notification = new Notification();
							$notification->chantier = $chantier->id;
							$notification->entite = $this->intervenant;
							$notification->prestataire = $chantier->do;
							$notification->message = $chantier->numero." // ".$intervenant->name." en attente de validation";
							$notification->save();
						
							// ON ENVOI LE MESSAGE AU BON PROFIL
							$profil = Profil::find($typeChantier->profil_1);
							$profil->notifier($equipier, "DOSSIER_COMPLET");
		
							// NOTIFICATION DU PRESTATAIRE
							$notification = new Notification();
							$notification->chantier = $chantier->id;
							$notification->entite = $this->intervenant;
							$notification->prestataire = $this->societe;;
							$notification->message = $chantier->numero." // ".$intervenant->name." en attente de validation";
							$notification->save();
							break;
					}
				}
			}
		}
	}
	
	// GESTION DES PIECES COTE LIVRAISON
	public function chargerPiecesL($livraison)
	{
		$lesPieces = Piece::where('entite', $this->id)->where('do', NULL)->where('chantier', NULL)->get();
		$myChantier =  Livraison::find($livraison);
		
		foreach($lesPieces as $piece)
		{
			$status = $this->checkPieceL($livraison, $piece->type_piece);
			if($status != 'success')
	        {	
				$pieceDo = Piece::where('entite', $this->id)->where('do', $myChantier->do)->where('type_piece', $piece->type_piece)->first();
				if($pieceDo)
					$pieceDo->delete();
				
				$myPiece = new Piece;
		        $myPiece->do = $myChantier->do;
		        $myPiece->entite = $this->id;
		        $myPiece->chemin = $piece->chemin;
		        $myPiece->type_piece = $piece->type_piece;
		        $myPiece->date_expiration = $piece->date_expiration;
		        $myPiece->extension = $piece->extension;

		        $myPiece->save();
	        }
		}
		
		$this->verifier($myChantier->do);
	}
	
	public function chargerPieceL($do, $typePiece)
	{
		$piece = Piece::where('entite', $this->id)->where('do', NULL)->where('livraison', NULL)->where('type_piece', $typePiece)->first();
		$pieceDo = Piece::where('entite', $this->id)->where('do', $do)->where('type_piece', $typePiece)->first();
		if($pieceDo)
			$pieceDo->delete();
		
		$myPiece = new Piece;
        $myPiece->do = $do;
        $myPiece->entite = $this->id;
        $myPiece->chemin = $piece->chemin;
        $myPiece->type_piece = $piece->type_piece;
        $myPiece->date_expiration = $piece->date_expiration;
        $myPiece->extension = $piece->extension;

        $myPiece->save();
		
		$this->verifierL($do);
		
		return "Pièce chargée";
	}
	
	public function checkPieceL($livraison, $typePieceArg)
	{
		$typePiece = TypePiece::find($typePieceArg);
		
		if($typePiece->livraison)
		{
			$piece = Piece::where('type_piece', $typePieceArg)
				->where('entite', $this->id)
				->where('livraison', $livraison)
				->orderBy('created_at', 'desc')->first();
			
			if($piece)
				return ($piece->statut == 'attente') ? 'warning' : 'success'; 
			else
				return 'default';
		}
		else
		{
			$mychantier = Livraison::find($livraison);
			
			$piece = Piece::where('type_piece', $typePieceArg)
				->where('entite', $this->id)
				->where('do', $mychantier->do)
				->orderBy('created_at', 'desc')->first();
			
			if($piece)
				return ($piece->statut == 'attente') ? 'warning' : 'success'; 
			else
				return 'default';
		}
		
		return 'default';
	}
	
	public function verifierL($do)
	{
		// ON VA VERIFIER TOUS LES CHANTIER DU GARS
		$equipiers = Livreur::where('intervenant', $this->id)->where('do', $do)->get();
		
		foreach($equipiers as $equipier)
		{
			// SI ON A DEJA NOTIFIE LE VALIDEUR QUE LE DOSSIER ETAIT COMPLET ON NE FAIT RIEN
			if(!$equipier->notifie)
			{
				if($equipier->complet())
				{	
					$chantier = Livraison::find($equipier->chantier);
					$societe = Societe::find($chantier->do);
				
					// ON VERIFIE LE CAS DU CHANTIER
					$typeChantier = DoChantier::find($chantier->type_chantier);
					$intervenant = Entite::find($this->id);
				
					switch($chantier->mecanisme)
					{
						// DANS UN CAS 1 OU 2 ON NE FAIT RIEN ET L'INTERVENANT EST VALIDE
						case 1 :
						case 2 :
							// NOTIFICATION DU DO
							$notification = new Notification();
							$notification->chantier = $this->chantier;
							$notification->entite = $this->intervenant;
							$notification->prestataire = $chantier->do;
							$notification->message = $chantier->numero." // ".$intervenant->name." validé";
							$notification->save();
			
							// NOTIFICATION DU PRESTATAIRE
							$notification = new Notification();
							$notification->chantier = $this->chantier;
							$notification->entite = $this->intervenant;
							$notification->prestataire = $this->societe;;
							$notification->message = $chantier->numero." // ".$intervenant->name." validé";
							$notification->save();
						
							$equipier->validation = time();
							$equipier->auteur_validation = 0;
							$equipier->notifie = 1;
							$equipier->save();
							break;
						case 3 :
						case 4 :
							// NOTIFICATION DU DO
							$notification = new Notification();
							$notification->chantier = $chantier->id;
							$notification->entite = $this->intervenant;
							$notification->prestataire = $chantier->do;
							$notification->message = $chantier->numero." // ".$intervenant->name." en attente de validation";
							$notification->save();
						
							// ON ENVOI LE MESSAGE AU BON PROFIL
							$profil = Profil::find($typeChantier->profil_1);
							$profil->notifier($equipier, "DOSSIER_COMPLET");
		
							// NOTIFICATION DU PRESTATAIRE
							$notification = new Notification();
							$notification->chantier = $chantier->id;
							$notification->entite = $this->intervenant;
							$notification->prestataire = $this->societe;;
							$notification->message = $chantier->numero." // ".$intervenant->name." en attente de validation";
							$notification->save();
							break;
					}
				}
			}
		}
	}
}
