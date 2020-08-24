<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Detachement extends Model
{
    //
	public function getValue ($soc, $ent)
	{
		$ligne = DB::table('detachements')->where('zone_soc', $soc)->where('zone_ent', $ent)->first();
		
		if($ligne)
		{
			return $ligne->pieces;
		}
		else
		{
			$detachement = new Detachement;
			$detachement->zone_soc = $soc;
			$detachement->zone_ent = $ent;
			$detachement->save();
				
			return "";
		}
	}
	
}
