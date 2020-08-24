<?php

namespace App\Http\Controllers;

use App\DoChantier;
use App\DoLivraison;
use App\User;
use App\Profil;
use App\Service;
use App\Habilitation;
use App\Societe;
use App\TypeChantier;
use App\TypeLivraison;
use App\TypePiece;
use App\Mail\NewCompteDo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class ComptesController extends Controller
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

    public function comptes(Request $request)
    {
		$user = \Auth::user();
		
		$keywords = "";
		$num_page = (isset($request->num_page)) ? $request->input("num_page") : 1;
		$sort = (isset($request->sort)) ? $request->input("sort") : "name";
		$sens = (isset($request->sens)) ? $request->input("sens") : "asc";
		$refresh = "/comptes";
		
		$page_title = 'Comptes';
		$page_description = '';
		
		if(isset($request->keywords) && $request->keywords != "")
		{
			$keywords = $request->keywords;
			
			$elements = User::where('societeID', $user->societeID)->where('name', 'like', '%'.$request->keywords.'%')->orderBy($sort, $sens)->offset(($num_page-1)*20)->limit(20)->get();
			
			$nb_items = User::where('societeID', $user->societeID)->where('name', 'like', '%'.$request->keywords.'%')->count();
			$nb_pages = max(1, intval($nb_items/20));
		}
		else
		{
			$elements = User::where('societeID', $user->societeID)->orderBy($sort, $sens)->offset(($num_page-1)*20)->limit(20)->get();
			
			$nb_items = User::where('societeID', $user->societeID)->count();
			$nb_pages = max(1, intval($nb_items/20));
		}	
		
		// BOUTONS D'ACTIONS
		$actions = array();
		$actions[] = array("url" => "/comptes/create/", "label" => "Nouveau compte", "style" => "info", "icon" => "<i class='fa fa-plus'></i>");
		
        return view('do/comptes', compact('page_title', 
		'page_description',
		'refresh',
		'user',
		'actions',
		'keywords', 
		'nb_pages',
		'num_page',
		'sort',
		'sens',
		'elements',
		'nb_items'));
    }
	
    public function show($id, $message = "EMPTY")
    {
		$user = \Auth::user();
		
		$compte = User::find($id);
		
		$page_title = 'Comptes';
		$page_description = '';
		
		$services = Service::where('societe', $compte->societeID)->where('deleted', NULL)->get();
		$profils = Profil::where('societe', $compte->societeID)->where('deleted', NULL)->get();
		
		// BOUTONS DE NAVIGATION
		$navs = array();
		$navs[] = array("url" => "/comptes", "label" => "Retour", "icon" => "<i class='fa fa-arrow-left'></i>");
		
		return view('do/frm-change', compact('page_title', 
		'page_description',
		'user',
		'navs',
		'compte',
		'services',
		'profils',
		'message'));
		
        return view('do/frm-change', ['user' => $user, 'compte' => $myCompte, 'profils' => $profils, 'services' => $services, 'message' => $message, 'open' => 'do']);
    }
	
    public function create($message = "EMPTY")
    {
		$user = \Auth::user();
		
		$myCompte = new User;
		
		$services = Service::where('societe', $user->societeID)->where('deleted', NULL)->get();
		$profils = Profil::where('societe', $user->societeID)->where('deleted', NULL)->get();
			
        return view('do/frm-create', ['user' => $user, 'compte' => $myCompte, 'profils' => $profils, 'services' => $services, 'message' => $message, 'open' => 'compte']);
    }
	
    public function changerdroits(Request $request)
    {
		$user = \Auth::user();
		
		$myCompte = User::find($request->input("id"));
		if($request->input("field") == "validation_pieces")
			$myCompte->validation_pieces = (!$myCompte->validation_pieces) ? true : false;
		
		if($request->input("field") == "validation_entites")
			$myCompte->validation_entites = (!$myCompte->validation_entites) ? true : false;
		
		if($request->input("field") == "validation_globale")
			$myCompte->validation_globale = (!$myCompte->validation_globale) ? true : false;
		
		$myCompte->save();
    }
	
    public function change(Request $request)
    {
		$user = \Auth::user();
		
        $this->validate($request, ['nom' => 'required']);

		try {
	        $myItem = User::find($request->input("id"));
	        $myItem->name = trim($request->input("nom")." ".$request->input("prenom"));
	        $myItem->nom = $request->input("nom");
	        $myItem->prenom = $request->input("prenom");
	        $myItem->telephone = $request->input("telephone");
	        $myItem->email = $request->input("email");
	        $myItem->service = $request->input("service");
	        $myItem->profil = $request->input("profil");
     
        	$myItem->save();
		} catch (\Exception $e) {
			return $this->show($request->input("id"), "ALREADY_EXISTS");
	    }
		
		
		return $this->comptes();
    }
	
    public function save(Request $request)
    {
		$user = \Auth::user();
		
        $this->validate($request, ['nom' => 'required']);

		try {
	        $myItem = new User;
	        $myItem->name = trim($request->input("nom")." ".$request->input("prenom"));
	        $myItem->nom = $request->input("nom");
	        $myItem->prenom = $request->input("prenom");
	        $myItem->telephone = $request->input("telephone");
	        $myItem->email = $request->input("email");
	        $myItem->service = $request->input("service");
	        $myItem->profil = $request->input("profil");
	        $myItem->societeID = $user->societeID;
	        $myItem->do = 1;
	        $myItem->groupe = 'compte';
			
			$mypass = str_random(8);
	        $myItem->password = Hash::make($mypass);
	        $myItem->fonction = $mypass;
     
        	$myItem->save();
			
			$res = Mail::to($request->input("email"))->send(new NewCompteDo($myItem));
		} catch (\Exception $e) {
			
			return $this->create("ALREADY_EXISTS");
	    }
		
		
		return $this->comptes();
    }
	
    public function deleteservice($id = 0)
    {
		$user = \Auth::user();
	
		$service = Service::find($id);
		$service->deleted = date('Y-m-d H:i:s');
		$service->save();
		
        return $this->services();
    }
	
	/**** HABILITATIONS ****/
    public function habilitations($id = 0)
    {
		$user = \Auth::user();
		$societe = Societe::find($user->societeID);
		
		$societe->choix_hab = 1;
		$societe->save();
		
		$habilitations = Habilitation::all();
		$oblig = ($societe->habilitations == "") ? array() : json_decode($societe->habilitations, true);
			
        return view('societe/habilitations', ['user' => $user, 'habilitations' => $habilitations, 'oblig' => $oblig, 'open' => 'parametres']);
    }
	
	/**** VALIDATION ****/
    public function refreshSelect(Request $request)
    {
		$user = \Auth::user();
		$typeDossier = TypeChantier::find($request->input("type"));
		$profils = Profil::where('societe', $user->societeID)->where('validation_entites', 1)->get();
		
		if($typeDossier->niveau_validation >= $request->input("niveau"))
		return view('do/select', ['user' => $user, 'typeDossier' => $typeDossier, 'profils' => $profils]);
    }
	
    public function validation()
    {
		$user = \Auth::user();
		$societe = Societe::find($user->societeID);
		$profils = Profil::where('societe', $user->societeID)->where('validation_entites', 1)->get();
		$typeDossiers = TypeChantier::all();
		
		if($societe->validation_chantier == "")
		{
			$societe->validation_chantier = json_encode(array("pieces" => 1, "validation" => 1, "niv_1" => 0, "niv_2" => 0));
			$societe->save();
		}
		else
		{
			
		}
		
		if($societe->validation_dav == "")
		{
			$societe->validation_dav = json_encode(array("pieces" => 1, "validation" => 1, "niv_1" => 0, "niv_2" => 0));
			$societe->save();
		}
		else
		{
			
		}
		
		return view('do/validation', ['user' => $user, 'typeDossiers' => $typeDossiers, 'societe' => $societe, 'profils' => $profils, 'validation' => json_decode($societe->validation_chantier), 'validation_dav' => json_decode($societe->validation_dav), 'open' => 'parametres']);
    }
	
    public function livraison()
    {
		$user = \Auth::user();
		$societe = Societe::find($user->societeID);
		$profils = Profil::where('societe', $user->societeID)->where('validation_entites', 1)->get();
		$typeDossiers = TypeLivraison::all();
		
		if($societe->validation_livraison == "")
		{
			$societe->validation_livraison = json_encode(array("pieces" => 1, "validation" => 1, "niv_1" => 0, "niv_2" => 0));
			$societe->save();
		}
		else
		{
			
		}
		
		return view('do/validationlivraison', ['user' => $user, 'typeDossiers' => $typeDossiers, 'societe' => $societe, 'profils' => $profils, 'validation' => json_decode($societe->validation_livraison), 'open' => 'parametres']);
    }
	
    public function saveTypeLivraison(Request $request)
    {
		$user = \Auth::user();
		
		$doChantier = DoLivraison::where('do', $user->societeID)->where('type_livraison', $request->input("type"))->first();
		if($doChantier)
		{
			switch($request->input("field"))
			{
				case "libelle" :
					$doChantier->libelle = $request->input("value");
					break;
				case "mecanisme_validation" :
					$doChantier->mecanisme_validation = $request->input("value");
					break;
				case "duree_validation" :
					$doChantier->duree_validation = $request->input("value");
					break;
				case "profil_1" :
					$doChantier->profil_1 = $request->input("value");
					break;
				case "profil_2" :
					$doChantier->profil_2 = $request->input("value");
					break;
				case "profil_3" :
					$doChantier->profil_3 = $request->input("value");
					break;
			}
			$doChantier->save();
		}
		else
		{
			$typeLivraison = TypeLivraison::find($request->input("type"));
		
			$doChantier = new DoLivraison();
			$doChantier->type_livraison = $request->input("type");
			$doChantier->niveau_validation = $typeLivraison->niveau_validation;
			$doChantier->do = $user->societeID;
			switch($request->input("field"))
			{
				case "libelle" :
					$doChantier->libelle = $request->input("value");
					break;
				case "mecanisme_validation" :
					$doChantier->mecanisme_validation = $request->input("value");
					break;
				case "duree_validation" :
					$doChantier->duree_validation = $request->input("value");
					break;
				case "profil_1" :
					$doChantier->profil_1 = $request->input("value");
					break;
				case "profil_2" :
					$doChantier->profil_2 = $request->input("value");
					break;
				case "profil_3" :
					$doChantier->profil_3 = $request->input("value");
					break;
			}
			$doChantier->save();
		}
	}
	
	// CONFIGURATION
    public function configuration()
    {
		$user = \Auth::user();
		$societe = Societe::find($user->societeID);
		
		return view('do/configuration', ['user' => $user, 'societe' => $societe, 'open' => 'parametres']);
    }
	
    public function saveconfiguration(Request $request)
    {
		$user = \Auth::user();
		$societe = Societe::find($user->societeID);
		
		$societe->rdv_active =  ($request->input("rdv_active")== "on") ? 1 : 0;
		$societe->validite_global = $request->input("validite_global");
		$societe->delai_vg = $request->input("delai_vg");
		$societe->validite_chantier = $request->input("validite_chantier");
		$societe->save();
		
		return $this->configuration();
    }
	
	// PIECES
    public function pieces()
    {
		$user = \Auth::user();
		$societe = Societe::find($user->societeID);
		
		$societe->choix_po = 1;
		$societe->save();
		
		$typePieces = TypePiece::where('intervenant', 1)->where('type_entite', NULL)->get();
		$typePieces2 = TypePiece::where('interim', 1)->where('type_entite', NULL)->get();
		$typePieces3 = TypePiece::where('etranger', 1)->where('type_entite', NULL)->get();
		$typePieces4 = TypePiece::where('vehicule', 1)->where('type_entite', NULL)->get();
		$typePieces6 = TypePiece::where('livraison', 1)->where('type_entite', NULL)->get();
		$typePieces7 = TypePiece::where('livreur', 1)->where('type_entite', NULL)->get();
		
		$oblig = ($societe->pieces_intervenants == "") ? array() : json_decode($societe->pieces_intervenants, true);
		$oblig2 = ($societe->pieces_interims == "") ? array() : json_decode($societe->pieces_interims, true);
		$oblig3 = ($societe->pieces_etrangers == "") ? array() : json_decode($societe->pieces_etrangers, true);
		$oblig4 = ($societe->pieces_vehicules == "") ? array() : json_decode($societe->pieces_vehicules, true);
		$oblig5 = ($societe->pieces_validation == "") ? array() : json_decode($societe->pieces_validation, true);
		$oblig6 = ($societe->pieces_livraisons == "") ? array() : json_decode($societe->pieces_livraisons, true);
		$oblig7 = ($societe->pieces_livreurs == "") ? array() : json_decode($societe->pieces_livreurs, true);
		
		return view('do/pieces', ['user' => $user, 'typePieces' => $typePieces, 'oblig' => $oblig, 'oblig2' => $oblig2, 'oblig3' => $oblig3, 'oblig4' => $oblig4, 'oblig5' => $oblig5, 'oblig6' => $oblig6, 'oblig7' => $oblig7, 'typePieces2' => $typePieces2, 'typePieces3' => $typePieces3, 'typePieces4' => $typePieces4, 'typePieces6' => $typePieces6, 'typePieces7' => $typePieces7, 'open' => 'parametres']);
    }
	
    public function savepiece(Request $request)
    {
		$user = \Auth::user();
		$societe = Societe::find($user->societeID);
		
		switch($request->input("field"))
		{
			case "intervenants" :
				$args = json_decode($societe->pieces_intervenants, true);
				
				if(isset($args[$request->input("key")]))
					unset($args[$request->input("key")]);
				else
					$args[$request->input("key")] = $request->input("key");
				
				$societe->pieces_intervenants = json_encode($args);
				$societe->save();
				break;
			case "interims" :
				$args = json_decode($societe->pieces_interims, true);
			
				if(isset($args[$request->input("key")]))
					unset($args[$request->input("key")]);
				else
					$args[$request->input("key")] = $request->input("key");
			
				$societe->pieces_interims = json_encode($args);
				$societe->save();
				break;
			case "etrangers" :
				$args = json_decode($societe->pieces_etrangers, true);
		
				if(isset($args[$request->input("key")]))
					unset($args[$request->input("key")]);
				else
					$args[$request->input("key")] = $request->input("key");
		
				$societe->pieces_etrangers = json_encode($args);
				$societe->save();
				break;
			case "vehicules" :
				$args = json_decode($societe->pieces_vehicules, true);
	
				if(isset($args[$request->input("key")]))
					unset($args[$request->input("key")]);
				else
					$args[$request->input("key")] = $request->input("key");
	
				$societe->pieces_vehicules = json_encode($args);
				$societe->save();
				break;
			case "global" :
				$args = json_decode($societe->pieces_validation, true);
	
				if(isset($args[$request->input("key")]))
					unset($args[$request->input("key")]);
				else
					$args[$request->input("key")] = $request->input("key");
	
				$societe->pieces_validation = json_encode($args);
				$societe->save();
				break;
			case "livraisons" :
				$args = json_decode($societe->pieces_livraisons, true);
	
				if(isset($args[$request->input("key")]))
					unset($args[$request->input("key")]);
				else
					$args[$request->input("key")] = $request->input("key");
	
				$societe->pieces_livraisons = json_encode($args);
				$societe->save();
				break;
			case "livreurs" :
				$args = json_decode($societe->pieces_livreurs, true);
	
				if(isset($args[$request->input("key")]))
					unset($args[$request->input("key")]);
				else
					$args[$request->input("key")] = $request->input("key");
	
				$societe->pieces_livreurs = json_encode($args);
				$societe->save();
				break;
		}
    }
	
    public function savevalidation(Request $request)
    {
		$user = \Auth::user();
		$societe = Societe::find($user->societeID);
		
		if($request->input("validation_entites") == "on")
			$societe->validation_chantier = json_encode(array("pieces" => ($request->input("validation_pieces") == "on") ? 1 : 0, "validation" => 1, "niv_1" => $request->input("niveau_1"), "niv_2" => $request->input("niveau_2")));
		else
			$societe->validation_chantier = json_encode(array("pieces" => ($request->input("validation_pieces") == "on") ? 1 : 0, "validation" => 0, "niv_1" => 0, "niv_2" => 0));
		
		if($request->input("validation_entites_dav") == "on")
			$societe->validation_dav = json_encode(array("validation" => 1, "niv_1" => $request->input("niveau_1_dav"), "niv_2" => $request->input("niveau_2_dav")));
		else
			$societe->validation_dav = json_encode(array("validation" => 0, "niv_1" => 0, "niv_2" => 0));
			
		$societe->save();
		
		return $this->validation();
    }
	
    public function saveTypeDossier(Request $request)
    {
		$user = \Auth::user();
		
		$doChantier = DoChantier::where('do', $user->societeID)->where('type_chantier', $request->input("type"))->first();
		if($doChantier)
		{
			switch($request->input("field"))
			{
				case "libelle" :
					$doChantier->libelle = $request->input("value");
					break;
				case "mecanisme_validation" :
					$doChantier->mecanisme_validation = $request->input("value");
					break;
				case "duree_validation" :
					$doChantier->duree_validation = $request->input("value");
					break;
				case "profil_1" :
					$doChantier->profil_1 = $request->input("value");
					break;
				case "profil_2" :
					$doChantier->profil_2 = $request->input("value");
					break;
				case "profil_3" :
					$doChantier->profil_3 = $request->input("value");
					break;
			}
			$doChantier->save();
		}
		else
		{
			$doChantier = new DoChantier();
			$doChantier->type_chantier = $request->input("type");
			$doChantier->do = $user->societeID;
			switch($request->input("field"))
			{
				case "libelle" :
					$doChantier->libelle = $request->input("value");
					break;
				case "mecanisme_validation" :
					$doChantier->mecanisme_validation = $request->input("value");
					break;
				case "duree_validation" :
					$doChantier->duree_validation = $request->input("value");
					break;
				case "profil_1" :
					$doChantier->profil_1 = $request->input("value");
					break;
				case "profil_2" :
					$doChantier->profil_2 = $request->input("value");
					break;
				case "profil_3" :
					$doChantier->profil_3 = $request->input("value");
					break;
			}
			$doChantier->save();
		}
	}
			
    public function savehabilitation(Request $request)
    {
		$user = \Auth::user();
		$societe = Societe::find($user->societeID);
		
		$args = json_decode($societe->habilitations, true);
				
		if(isset($args[$request->input("id")]))
			unset($args[$request->input("id")]);
		else
			$args[$request->input("id")] = $request->input("id");
		
		$societe->habilitations = json_encode($args);
		$societe->save();
    }
	
	/**** SERVICES ****/
    public function services($id = 0)
    {
		$user = \Auth::user();
		
		$services = Service::where('societe', $user->societeID)->where('deleted', NULL)->get();
		$service = ($id == 0) ? new Service : Service::find($id);
		$new = ($id == 0) ? true : false;
			
        return view('do/services', ['user' => $user, 'services' => $services, 'service' => $service, 'new' => $new, 'open' => 'parametres']);
    }
	
    public function saveservice(Request $request)
    {
		$user = \Auth::user();
		
        $this->validate($request, ['libelle' => 'required']);
		
		if($request->input("new"))
		{
			$service = new Service;
			$service->libelle = $request->input("libelle");
			$service->societe = $user->societeID;
			$service->save();
		}
		else
		{
			try {
				$service = Service::find($request->input("id"));
				$service->libelle = $request->input("libelle");
				$service->societe = $user->societeID;
				$service->save();
			} catch (\Exception $e) {
				return $this->services();
		    }
		}
				
		return $this->services();
    }
	
    public function deleteprofil($id = 0)
    {
		$user = \Auth::user();
	
		$profil = Profil::find($id);
		$profil->deleted = date('Y-m-d H:i:s');
		$profil->save();
		
        return $this->profils();
    }
	
    public function profils($id = 0)
    {
		$user = \Auth::user();
		
		$profils = Profil::where('societe', $user->societeID)->where('deleted', NULL)->get();
		$profil = ($id == 0) ? new Profil : Profil::find($id);
		$new = ($id == 0) ? true : false;
			
        return view('do/profils', ['user' => $user, 'profils' => $profils, 'profil' => $profil, 'new' => $new, 'open' => 'parametres']);
    }
	
    public function saveprofil(Request $request)
    {
		$user = \Auth::user();
		
        $this->validate($request, ['libelle' => 'required']);
		
		if($request->input("new"))
		{
			$profil = new Profil;
			$profil->libelle = $request->input("libelle");
			$profil->societe = $user->societeID;
			$profil->validation_pieces = ($request->input("validation_pieces") == "on") ? 1 : 0;
			$profil->visualiser_pieces = ($request->input("visualiser_pieces") == "on") ? 1 : 0;
			$profil->telecharger_pieces = ($request->input("telecharger_pieces") == "on") ? 1 : 0;
			$profil->rejuger_pieces = ($request->input("rejuger_pieces") == "on") ? 1 : 0;
			$profil->validation_entites = ($request->input("validation_entites") == "on") ? 1 : 0;
			$profil->initier_chantier = ($request->input("initier_chantier") == "on") ? 1 : 0;
			$profil->initier_livraison = ($request->input("initier_livraison") == "on") ? 1 : 0;
			$profil->valider_livraison = ($request->input("valider_livraison") == "on") ? 1 : 0;
			$profil->gerer_livraison = ($request->input("gerer_livraison") == "on") ? 1 : 0;
			$profil->save();
		}
		else
		{
			try {
				$profil = Profil::find($request->input("id"));
				$profil->libelle = $request->input("libelle");
				$profil->societe = $user->societeID;
				$profil->validation_pieces = ($request->input("validation_pieces") == "on") ? 1 : 0;
				$profil->visualiser_pieces = ($request->input("visualiser_pieces") == "on") ? 1 : 0;
				$profil->telecharger_pieces = ($request->input("telecharger_pieces") == "on") ? 1 : 0;
				$profil->rejuger_pieces = ($request->input("rejuger_pieces") == "on") ? 1 : 0;
				$profil->validation_entites = ($request->input("validation_entites") == "on") ? 1 : 0;
				$profil->initier_chantier = ($request->input("initier_chantier") == "on") ? 1 : 0;
				$profil->initier_livraison = ($request->input("initier_livraison") == "on") ? 1 : 0;
				$profil->valider_livraison = ($request->input("valider_livraison") == "on") ? 1 : 0;
				$profil->gerer_livraison = ($request->input("gerer_livraison") == "on") ? 1 : 0;
				$profil->save();
			} catch (\Exception $e) {
				return $this->profils();
		    }
		}
				
		return $this->profils();
    }
	
    public function abonnement()
    {
		$user = \Auth::user();
			
        return view('do/abonnement', ['user' => $user, 'open' => 'parametres']);
    }
}
