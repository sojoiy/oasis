<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EntiteHabilitation extends Model
{
    //
	use SoftDeletes;
	protected $table = 'entite_habilitation';
	
	public function pieces($chantierID)
	{
		$pieces = Piece::where('entite', $this->id)->get();
		return $pieces;
	}
	
	public function getChamp($label)
	{
		$values = json_decode($this->args);
		
		return $values->$label->value;
	}
	
	public function libelle()
	{
		$habilitation = Habilitation::find($this->habilitation);
		return $habilitation->libelle;
	}
}
