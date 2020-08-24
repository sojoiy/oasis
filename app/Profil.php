<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profil extends Model
{
	use SoftDeletes;
	
    //
	public function libelle_complet()
	{
		$societe = Societe::find($this->societe);
		return $this->libelle." (".$societe->raisonSociale.")";
	}
	
	public function notifier($equipier, $message)
	{
		$users = User::where('profil', $this->id)->get();
		
		foreach($users as $user)
		{
			$message = new Message();
			$message->chantier = $equipier->chantier;
			$message->user = $user->id;
			$message->entite = $equipier->intervenant;
			$message->message = "Intervenant en attente de validation";
			$message->save();
		}
		
		return true;
	}
}
