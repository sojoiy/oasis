<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Creneau extends Model
{
    protected $table = 'creneaux';
    function nombre_places_dispo(){
        return Equipier::where('rdv',$this->id)->count();
    }
}
