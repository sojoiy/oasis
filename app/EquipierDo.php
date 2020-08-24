<?php

namespace App;

use App\Entite;
use App\Creneau;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;

class EquipierDo extends Model
{
    //
	protected $table = 'equipiers_do';
	
	public function statut()
	{
		return "En attente";
	}
	
	public function url()
	{
		if($this->accesskey)
			return $this->accesskey;
		else
		{
			$this->accesskey = md5($this->email.$this->id.date('dmY'));
			$this->save();
			
			return $this->accesskey;
		}
	}
}
