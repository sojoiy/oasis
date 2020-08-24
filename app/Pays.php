<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pays extends Model
{
    //
	public function nom_zone()
	{
		if($this->zone != NULL)
		{
			$zone = Zone::find($this->zone);
			return $zone->libelle;
		}
		else
			return "-";
	}
}
