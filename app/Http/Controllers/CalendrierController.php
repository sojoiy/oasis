<?php

namespace App\Http\Controllers;

use App\Affectation;
use App\Creneau;
use App\Fermeture;
use App\Horaire;
use App\Semaine;
use App\Societe;
use App\TypeSemaine;
use App\User;
use Illuminate\Http\Request;

class CalendrierController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
	
    public function deletefermeture($id = 0)
    {
		$user = \Auth::user();
	
		$service = Fermeture::find($id);
		$service->delete();
		
        return $this->fermeture();
    }
	
    public function fermeture($id = 0)
    {
		$user = \Auth::user();
		
		$fermetures = Fermeture::where('societe', $user->societeID)->get();
		$fermeture = ($id == 0) ? new Fermeture : Fermeture::find($id);
		$new = ($id == 0) ? true : false;
			
        return view('calendrier/fermetures', ['user' => $user, 'fermetures' => $fermetures, 'fermeture' => $fermeture, 'new' => $new]);
    }
	
    public function savefermeture(Request $request)
    {
		$user = \Auth::user();
		
        $this->validate($request, ['libelle' => 'required']);
		
		if($request->input("new"))
		{
			$service = new Fermeture;
			$service->libelle = $request->input("libelle");
			$service->commentaire = $request->input("commentaire");
			$service->date_debut = $request->input("date_debut");
			$service->date_fin = $request->input("date_fin");
			$service->societe = $user->societeID;
			$service->save();
		}
		else
		{
			try {
				$service = Fermeture::find($request->input("id"));
				$service->libelle = $request->input("libelle");
				$service->commentaire = $request->input("commentaire");
				$service->date_debut = $request->input("date_debut");
				$service->date_fin = $request->input("date_fin");
				$service->save();
			} catch (\Exception $e) {
				return $this->fermeture();
		    }
		}
				
		return $this->fermeture();
    }
	
	
	/** CRENEAUX **/
    public function deletecreneau($id = 0)
    {
		$user = \Auth::user();
	
		$service = Creneau::find($id);
		$service->delete();
		
        return $this->creneau();
    }
	
    public function creneaux($id = 0)
    {
		$user = \Auth::user();
		
		$creneaux = Creneau::where('societe', $user->societeID)->get();
		$creneau = ($id == 0) ? new Creneau : Creneau::find($id);
		$new = ($id == 0) ? true : false;
			
        return view('calendrier/creneaux', ['user' => $user, 'creneaux' => $creneaux, 'creneau' => $creneau, 'new' => $new]);
    }
	
    public function savecreneau(Request $request)
    {
		$user = \Auth::user();
		
        $this->validate($request, ['date_debut' => 'required']);
		
		if($request->input("new"))
		{
			$service = new Creneau;
			$service->date_debut = $request->input("date_debut");
			$service->duree = $request->input("duree");
			$service->nombre_places = $request->input("nombre_places");
			$service->societe = $user->societeID;
			$service->save();
		}
		else
		{
			try {
				$service = Creneau::find($request->input("id"));
				$service->date_debut = $request->input("date_debut");
				$service->duree = $request->input("duree");
				$service->nombre_places = $request->input("nombre_places");
				$service->save();
			} catch (\Exception $e) {
				return $this->creneaux();
		    }
		}
				
		return $this->creneaux();
    }
	
    public function affectation(Request $request)
    {
		$user = \Auth::user();
		
		$annee = (isset($request->annee)) ? $request->annee : date('Y');
		
		$horaires = Horaire::where('societe', $user->societeID)->get();
		$societe = Societe::find($user->societeID);
		$semaines = Semaine::where('annee', $annee)->get();
		$type_semaines = TypeSemaine::where('societe', $user->societeID)->get();
		
		return view('calendrier/affectation', ['user' => $user, 'typeSemaines' => $type_semaines, 'semaines' => $semaines, 'horaires' => $horaires, 'societe' => $societe]);
    }
	
    public function creerCreneaux(Request $request)
    {
		$user = \Auth::user();
		$societe = Societe::find($user->societeID);
		
		$mySemaine = Semaine::find($request->semaine);
		$typeSemaine = TypeSemaine::find($societe->getTypeSemaine($request->semaine));
		
		if($typeSemaine)
		{
			$firstDay = $mySemaine->date_debut;
			$creneaux = json_decode($typeSemaine->lundi, true);
			// LUNDI
			foreach($creneaux as $creneau => $nombre_places)
			{
				// on calcule la durée
				$horaires = explode("-", $creneau);
				
				$creneau = new Creneau();
				$creneau->societe = $user->societeID;
				$creneau->duree = 30;
				$creneau->nombre_places = $nombre_places;
				$creneau->date_debut = $mySemaine->date_debut." ".$horaires[0];
				$creneau->semaine = $request->semaine;
				$creneau->save();
			}
		}
		
		return $this->affectation($request);
    }
	
    public function modifierTypeSemaines(Request $request)
    {
		$user = \Auth::user();
	
		foreach($request->semaines as $semaine)
		{
			$affectation = Affectation::where('societe', $user->societeID)->where('semaine', $semaine)->first();
			if($affectation)
			{
				$affectation->type_semaine = $request->type_semaine;
				$affectation->save();
			}	
			else
			{
				$affectation = new Affectation();
				$affectation->type_semaine = $request->type_semaine;
				$affectation->semaine = $semaine;
				$affectation->societe = $user->societeID;
				$affectation->save();
			}
		}
	
		return $this->affectation($request);
    }
		
    public function affecter_semaines(Request $request)
    {
		$user = \Auth::user();
		
		foreach($request->semaines as $semaine)
		{
			$affectation = Affectation::where('societe', $user->societeID)->where('semaine', $semaine)->first();
			if($affectation)
			{
				$affectation->type_semaine = $request->type_semaine;
				$affectation->save();
			}	
			else
			{
				$affectation = new Affectation();
				$affectation->type_semaine = $request->type_semaine;
				$affectation->semaine = $semaine;
				$affectation->societe = $user->societeID;
				$affectation->save();
			}
		}
		
		return $this->affectation($request);
    }
	
    public function newtype(Request $request)
    {
		$user = \Auth::user();
		
		$typeSemaine = new TypeSemaine();
		$typeSemaine->libelle = "Nouveau type";
		$typeSemaine->societe = $user->societeID;
		$typeSemaine->defaut = false;
		$typeSemaine->save();
			
		return view('calendrier/new_type', ['user' => $user, 'typeSemaine' => $typeSemaine]);
    }
	
    public function delete(Request $request)
    {
		$user = \Auth::user();
		
		$html = '';
		$typeSemaine = TypeSemaine::find($request->id);
		switch(strtolower($request->jour))
		{
			case "lundi" :
				$creneaux = json_decode($typeSemaine->lundi, true);
				unset($creneaux[$request->key]);
					
				ksort($creneaux);
				$typeSemaine->lundi = json_encode($creneaux);
				$typeSemaine->save();
				
				foreach($creneaux as $key => $value)
				{
					$html .= $key.' ('.$value.') <i onclick="removeCreneau('.$request->id.', \''.$key.'\', \'Lundi\')" class="fa fa-times"></i><br>';
				}
				break;
			case "mardi" :
				break;
			case "mercredi" :
				break;
			case "jeudi" :
				break;
			case "vendredi" :
				break;
			case "samedi" :
				break;
			case "dimanche" :
				break;
			
		}
		
		return $html;
    }
	
	public function changertype(Request $request)
	{
		$typeSemaine = TypeSemaine::find($request->type);
		$typeSemaine->libelle = $request->libelle;
		$typeSemaine->save();
	}	
		
    public function ajouterCreneau(Request $request)
    {
		$user = \Auth::user();
		
		$typeSemaine = TypeSemaine::find($request->id); 
		
		$html = '';
		
		switch($request->jour)
		{
			case "lundi" :
				$creneaux = json_decode($typeSemaine->lundi, true);
				
				if($request->heure_debut < $request->heure_fin)
				{
					$creneaux[$request->heure_debut."-".$request->heure_fin] = $request->places;
					
					ksort($creneaux);
					$typeSemaine->lundi = json_encode($creneaux);
					$typeSemaine->save();
				}
				
				foreach($creneaux as $key => $value)
				{
					$html .= $key.' ('.$value.') <i onclick="removeCreneau('.$request->id.', \''.$key.'\', \'Lundi\')" class="fa fa-times"></i><br>';
				}
				break;
			case "mardi" :
				break;
			case "mercredi" :
				break;
			case "jeudi" :
				break;
			case "vendredi" :
				break;
			case "samedi" :
				break;
			case "dimanche" :
				break;
			
		}
			
		return $html;
    }
}
