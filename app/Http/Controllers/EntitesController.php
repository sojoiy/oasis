<?php

namespace App\Http\Controllers;

use App\Autorisation;
use App\Chantier;
use App\ChantierDo;
use App\Detachement;
use App\Entite;
use App\Equipier;
use App\EntiteHabilitation;
use App\Habilitation;
use App\Piece;
use App\Pays;
use App\Societe;
use App\TypeEntite;
use App\TypePiece;
use Illuminate\Http\Request;
use League\Flysystem\FileNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File; 
use PDF;

class EntitesController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users');
    }
	
    /**
     * Affiche la liste des intervenants d'un prestataire.
     *
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {
		$user = \Auth::user();
        Storage::put("temp/".$request->input("data"), $request->file("file"));
    }
	
    /**
     * RETOURNE UN JETON D'IDENTIFICATION POUR LE CHARGEMENT DES PIECES
     *
     * @return \Illuminate\Http\Response
     */
    public function gettoken(Request $request)
    {
		$user = \Auth::user();
		$file_ID = str_random(50);
        return $file_ID;
    }
		
	// AFFICHE LA LISTE DES INTERVENANTS D'UN PRESTATAIRE
	// intervenants
    public function intervenants()
    {
		$user = \Auth::user();
		
		$user = \Auth::user();
		
		$societe = Societe::find($user->societeID);
		
        $page_title = 'Mes ressources';
        $page_description = "Intervenants";
		
		$keywords = "";
		$num_page = (isset($request->num_page)) ? $request->input("num_page") : 1;
		$sort = (isset($request->sort)) ? $request->input("sort") : "name";
		$sens = (isset($request->sens)) ? $request->input("sens") : "asc";
		$refresh = "/intervenants";
		
		if(isset($request->keywords) && $request->keywords != "")
		{
			$keywords = $request->keywords;
			
			$elements = Entite::where('categorie', 'intervenant')->where('statut', 'actif')->where('societe', $user->societeID)->where('name', 'like', '%'.$request->keywords.'%')->orderBy($sort, $sens)->offset(($num_page-1)*20)->limit(20)->get();
			$nb_items = Entite::where('categorie', 'intervenant')->where('statut', 'actif')->where('societe', $user->societeID)->where('name', 'like', '%'.$request->keywords.'%')->count();
			$nb_pages = max(1, intval($nb_items/20));
		}
		else
		{
			$elements = Entite::where('categorie', 'intervenant')->where('statut', 'actif')->where('societe', $user->societeID)->orderBy($sort, $sens)->offset(($num_page-1)*20)->limit(20)->get();
			$nb_items = Entite::where('categorie', 'intervenant')->where('statut', 'actif')->where('societe', $user->societeID)->count();
			$nb_pages = max(1, intval($nb_items/20));
		}	
		
        // BOUTONS D'ACTIONS
		$actions = array();
		$actions[] = array("url" => "/add-intervenant", "label" => "Ajouter un intervenant", "style" => "info", "icon" => "<i class='fa fa-plus'></i>");
		
		// BOUTONS DE POPUP
		$popups = array();
		
		// BOUTONS DE NAVIGATION
		$navs = array();
		
        return view('presta/liste/intervenants', compact('page_title', 
		'page_description', 
		'refresh', 
		'user', 
		'keywords', 
		'nb_pages', 
		'societe', 
		'num_page', 
		'sort', 
		'sens', 
		'elements',
		'nb_items', 
		'actions', 
		'popups', 
		'navs'));
    }
	
    
	// AFFICHE LA LISTE DES VEHICULES D'UN PRESTATAIRE
	// vehicules
    public function vehicules()
    {
		$user = \Auth::user();
		
		
		$societe = Societe::find($user->societeID);
		
        $page_title = 'Mes ressources';
        $page_description = "vehicules";
		
		$keywords = "";
		$num_page = (isset($request->num_page)) ? $request->input("num_page") : 1;
		$sort = (isset($request->sort)) ? $request->input("sort") : "name";
		$sens = (isset($request->sens)) ? $request->input("sens") : "asc";
		$refresh = "/vehicules";
		
		if(isset($request->keywords) && $request->keywords != "")
		{
			$keywords = $request->keywords;
			
			$elements = Entite::where('categorie', 'vehicule')->where('statut', 'actif')->where('societe', $user->societeID)->where('name', 'like', '%'.$request->keywords.'%')->orderBy($sort, $sens)->offset(($num_page-1)*20)->limit(20)->get();
			$nb_items = Entite::where('categorie', 'vehicule')->where('statut', 'actif')->where('societe', $user->societeID)->where('name', 'like', '%'.$request->keywords.'%')->count();
			$nb_pages = max(1, intval($nb_items/20));
		}
		else
		{
			$elements = Entite::where('categorie', 'vehicule')->where('statut', 'actif')->where('societe', $user->societeID)->orderBy($sort, $sens)->offset(($num_page-1)*20)->limit(20)->get();
			$nb_items = Entite::where('categorie', 'vehicule')->where('statut', 'actif')->where('societe', $user->societeID)->count();
			$nb_pages = max(1, intval($nb_items/20));
		}	
	
        // BOUTONS D'ACTIONS
		$actions = array();
		$actions[] = array("url" => "/add-vehicule", "label" => "Ajouter un vehicule", "style" => "info", "icon" => "<i class='fa fa-plus'></i>");
		
		// BOUTONS DE POPUP
		$popups = array();
		
		// BOUTONS DE NAVIGATION
		$navs = array();
		
        return view('vehicule/vehicules', compact('page_title', 
		'page_description', 
		'refresh', 
		'user', 
		'keywords', 
		'nb_pages', 
		'societe', 
		'num_page', 
		'sort', 
		'sens', 
		'elements',
		'nb_items', 
		'actions', 
		'popups', 
		'navs'));
    }
	
    /**
     * Affiche la liste des autres entités d'un prestataire.
     *
     * @return \Illuminate\Http\Response
     */
    public function autres()
    {
		$user = \Auth::user();
		
		$entites = Entite::where('categorie', 'autre')->where('societe', $user->societeID)->where('statut', 'actif')->get();
			
        return view('entite/autres', ['user' => $user, 'entites' => $entites, 'open' => 'entite']);
    }
	
	public function supprimerdocument(Request $request)
    {
		$user = \Auth::user();
	
		$typePiece = TypePiece::find($request->input("id"));
		$typePiece->delete();
    }
	
	public function supprimertype(Request $request)
    {
		$user = \Auth::user();
	
		$typeEntite = TypeEntite::find($request->input("id"));
		$typeEntite->delete();
    }
    
	public function adddocument(Request $request)
    {
		$user = \Auth::user();
		
		$typeEntite = TypeEntite::find($request->input("id"));
		
		$typePiece = new TypePiece();
		$typePiece->libelle = $request->input("libelle");
		$typePiece->abbreviation = $request->input("abbr");
		$typePiece->formats = $request->input("nature");
		$typePiece->type_entite = $request->input("id");
		$typePiece->save();
		
		$typesPieces = TypePiece::where('type_entite', $request->input("id"))->get();
		
        return view('type_entite/documents', ['user' => $user, 'typeEntite' => $typeEntite, 'typesPieces' => $typesPieces]);
    }
	
    /**
     * Affiche un formulaire permettant de créer un nouveau type d'entités
     *
     * @return \Illuminate\Http\Response
     */
    public function createnew($message = "", $type_entite = 0)
    {
		$user = \Auth::user();
		
		$lesTypesEntites = TypeEntite::where('societe', $user->societeID)->get();
			
        return view('entite/frm-add', ['user' => $user, 'open' => 'entite', 'lesTypesEntites' => $lesTypesEntites, 'message' => $message, 'type_entite' => $type_entite]);
    }
	
    public function showEntite($id, $message = "EMPTY")
    {
		$user = \Auth::user();
		
		$entite = Entite::find($id);
		$typeEntite = TypeEntite::find($entite->type_entite);
		$lesChamps = json_decode($typeEntite->champs);
		
		$pieces = Piece::where('entite', $id)->get();
		$chantiers = ChantierDo::where('entite', $id)->get();
		
		$typesPieces = TypePiece::where('type_entite', $entite->type_entite)->get();
			
        return view('entite/frm-change', ['user' => $user, 'open' => 'entite', 'entite' => $entite, 'chantiers' => $chantiers, 'pieces' => $pieces, 'message' => 'EMPTY', 'typeEntite' => $typeEntite, 'lesChamps' => $lesChamps, 'typesPieces' => $typesPieces, 'message' => $message]);
    }
	
	public function typeentite($id, $message = "EMPTY")
    {
		$user = \Auth::user();
		
		$typeEntite = TypeEntite::find($id);
		$typesPieces = TypePiece::where('type_entite', $id)->get();

		$lesChamps = json_decode($typeEntite->champs);
			
        return view('type_entite/frm-change', ['user' => $user, 'open' => 'entite', 'typesPieces' => $typesPieces, 'typeEntite' => $typeEntite, 'lesChamps' => $lesChamps, 'message' => $message]);
    }
	
	public function listertypes(Request $request)
    {
		$user = \Auth::user();
		
		$keywords = "";
		$num_page = (isset($request->num_page)) ? $request->input("num_page") : 1;
		$sort = (isset($request->sort)) ? $request->input("sort") : "libelle";
		$sens = (isset($request->sens)) ? $request->input("sens") : "asc";
		
		if(isset($request->keywords) && $request->keywords != "")
		{
			$keywords = $request->keywords;
			
			$typeEntites = TypeEntite::where('societe', $user->societeID)->where('libelle', 'like', '%'.$request->keywords.'%')->orderBy($sort, $sens)->offset(($num_page-1)*20)->limit(20)->get();
			
			$nb_agences = TypeEntite::where('libelle', 'like', '%'.$request->keywords.'%')->get();
			$nb_pages = max(1, intval(sizeof($nb_agences)/20));
		}
		else
		{
			$typeEntites = TypeEntite::where('societe', $user->societeID)->where('id', '>', 0)->orderBy($sort, $sens)->offset(($num_page-1)*20)->limit(20)->get();
			
			$nb_agences = TypeEntite::all();
			$nb_pages = max(1, intval(sizeof($nb_agences)/20));
		}	
			
        return view('type_entite/lister', ['user' => $user, 'open' => 'entite', 'typeEntites' => $typeEntites, 'keywords' => $keywords, 'nb_pages' => $nb_pages, 'num_page' => $num_page, 'sort' => $sort, 'sens' => $sens]);
    }
		
    public function savenew(Request $request)
    {
		$user = \Auth::user();
		
		$entite = Entite::where('name', $request->input("name"))->first();
		if($entite)
		{
			return $this->createnew('EXISTS', $request->input("typeEntiteID"));
		}
		else
		{
			$entite = new Entite;
			$entite->categorie = "autre";
			$entite->statut = "actif";
			$entite->name = $request->input("name");
			$entite->societe = $user->societeID;
			$entite->type_entite = $request->input("typeEntiteID");
			
			$typeEntite = TypeEntite::find($request->input("typeEntiteID"));
			$lesChamps = json_decode($typeEntite->champs);

			$args = array();
			foreach($lesChamps as $key => $unChamp)
			{
				if(isset($request->$key))
					$args[$key]["value"] = $request->input($key);
			}

			$entite->args = json_encode($args);
			$entite->save();
			
			return $this->autres();
		}
    }
	
    public function saveentite(Request $request)
    {
		$user = \Auth::user();
		
		$entite = Entite::where('name', $request->input("name"))->where('id', '<>', $request->id)->first();
		if($entite)
		{
			return $this->showEntite($request->id);
		}
		else
		{
			$entite = Entite::find($request->id);
			$entite->name = $request->input("name");
			
			$typeEntite = TypeEntite::find($entite->type_entite);
			$lesChamps = json_decode($typeEntite->champs);

			$args = array();
			foreach($lesChamps as $key => $unChamp)
			{
				if(isset($request->$key))
					$args[$key]["value"] = $request->input($key);
			}

			$entite->args = json_encode($args);
			$entite->save();
			
			return $this->autres();
		}
    }
	
    public function saveold(Request $request)
    {
		$user = \Auth::user();
		
		$typeEntite = TypeEntite::find($request->input("id"));
		$typeEntite->libelle = $request->input("libelle");
		
		$args = array();
		$args["champs1"]["name"] = $request->input("champs1");
		$args["champs1"]["type"] = $request->input("type_champs1");

		$args["champs2"]["name"] = $request->input("champs2");
		$args["champs2"]["type"] = $request->input("type_champs2");

		$typeEntite->champs = json_encode($args);
		$typeEntite->save();
			
        return $this->autres();
    }
	
    public function updateform(Request $request)
    {
		$user = \Auth::user();
		
		$typeEntite = TypeEntite::find($request->input("id"));
		$lesChamps = json_decode($typeEntite->champs);
			
        return view('entite/new-form', ['user' => $user, 'typeEntite' => $typeEntite, 'lesChamps' => $lesChamps]);
    }
	
	
    /**
     * Affiche un formulaire permettant de créer un nouveau type d'entités
     *
     * @return \Illuminate\Http\Response
     */
    public function createtype()
    {
		$user = \Auth::user();
			
        return view('entite/create-type', ['user' => $user, 'open' => 'entite', 'message' => 'EMPTY']);
    }
	
    public function ajoutertype(Request $request)
    {
		$user = \Auth::user();
		
		$typeEntite = new TypeEntite;
		$typeEntite->libelle = $request->input("libelle");
		$typeEntite->societe = $user->societeID;
		
		$args = array();
		$args["champs1"]["name"] = $request->input("champ1");
		$args["champs1"]["type"] = $request->input("type_champs1");

		$args["champs2"]["name"] = $request->input("champ2");
		$args["champs2"]["type"] = $request->input("type_champs2");
		
		$typeEntite->champs = json_encode($args);
		$typeEntite->save();
			
        return $this->listertypes($request);
    }
		
    /**
     * Affiche le formulaire de création d'une nouvelle entité.
     *
     * @return \Illuminate\Http\Response
     */
    public function nouveau()
    {
		$user = \Auth::user();
		$lesPays = Pays::all();
		
        return view('intervenant/frm-add', ['user' => $user, 'open' => 'entite', 'lesPays' => $lesPays]);
    }
	
    /**
     * Affiche le formulaire de création d'une nouvelle entité.
     *
     * @return \Illuminate\Http\Response
     */
    public function nouveauvehicule()
    {
		$user = \Auth::user();
		$lesPays = Pays::all();
		
        return view('vehicule/frm-add', ['user' => $user, 'open' => 'entite', 'lesPays' => $lesPays]);
    }
	
    /**
     * Affiche le formulaire de création d'une nouvelle entité.
     *
     * @return \Illuminate\Http\Response
     */
    public function renewautorisation(Request $request)
    {
		$user = \Auth::user();
		
		$autorisation = Autorisation::find($request->input("autorisation"));
		$autorisation->statut = "renew";
		
		$entite = Entite::find($autorisation->entite);
		return $entite->getRenewState($autorisation->do);
    }
	
    /**
     * Affiche le formulaire de création d'une nouvelle entité.
     *
     * @return \Illuminate\Http\Response
     */
    public function carnet($entite)
    {
		$user = \Auth::user();
		
		$entite = Entite::find($entite);
		$employeur = Societe::find($entite->societe);
		
		$pdf = PDF::loadView('documents/carnet', ['user' => $user, 'entite' => $entite, 'employeur' => $employeur]);
		return $pdf->download('carnet.pdf');
    }
	
	// AFFICHE LA LISTE DES INTERVENANTS D'UN PRESTATAIRE
	// intervenants/show/{id}
    public function show($id, $message = "EMPTY")
    {
		$user = \Auth::user();
		
		$entite = Entite::find($id);
		
        $page_title = 'Mes ressources';
        $page_description = $entite->name;
        $callback = '/intervenants';
		
		$pieces = Piece::where('entite', $id)->get();
		$habilitations = EntiteHabilitation::where('entite', $id)->get();
		
		$res = DB::table('chantiers')
			->whereIn('id', function($query) use ($id)
			    {
			        $query->select(DB::raw('chantier'))
			              ->from('equipiers')
			              ->whereRaw('equipiers.intervenant = '.$id);
			    })
            ->get('chantiers.*');
				
		$chantiers = array();
		$lesDo = array();
		foreach($res as $r)
		{
			$chantier = Chantier::find($r->id);
			$chantiers[] = $chantier;
			$lesDo[$chantier->do] = Societe::find($chantier->do);
		}
		
		$typesPieces = array();
		switch($entite->nature)
		{
			case "intervenant" :
				$typesPieces = TypePiece::where('intervenant', 1)->where('chantier', 0)->get();
				break;
			case "etranger" :
				// POUR LES ETRANGERS ON VA CHERCHER LES PIECES EN FONCTION DU PROFIL
				$detachement = Detachement::where('zone_soc', $entite->zone_entreprise)->where('zone_ent', $entite->zone_entite)->first();
				if($detachement)
				{
					$types = explode(",", $detachement->pieces);
					foreach($types as $type)
					{
						$tp = TypePiece::where('abbreviation', $type)->where('chantier', 0)->first();
						if($tp)
							$typesPieces[] = $tp;
					}
				}
				
				//print_r($typesPieces);
				break;
			case "interim" :
				$typesPieces = TypePiece::where('interim', 1)->where('chantier', 0)->get();
				break;
		}	
		
		$typesHabilitations = Habilitation::all();
		$lesPays = Pays::all();
		
        return view('presta/affichage/intervenant', compact('page_title', 'page_description', 'callback', 'user', 'lesDo', 'entite', 'chantiers', 'typesHabilitations', 'typesPieces', 'habilitations', 'pieces', 'lesPays', 'message'));
		
    }
	
    /**
     * Affiche le formulaire de modification d'une nouvelle entité.
     *
     * @return \Illuminate\Http\Response
     */
    public function vehiculeshow($id, $message = "EMPTY")
    {
		$user = \Auth::user();
		
		$myItem = Entite::find($id);
		$pieces = Piece::where('entite', $id)->get();
		$habilitations = EntiteHabilitation::where('entite', $id)->get();
		
		$res = DB::table('chantiers')
			->whereIn('id', function($query) use ($id)
			    {
			        $query->select(DB::raw('chantier'))
			              ->from('equipiers')
			              ->whereRaw('equipiers.intervenant = '.$id);
			    })
            ->get('chantiers.*');
				
		$chantiers = array();
		foreach($res as $r)
			$chantiers[] = Chantier::find($r->id);
		
		$typesPieces = TypePiece::where('vehicule', 1)->get();
		
        return view('vehicule/frm-change', ['user' => $user, 'entite' => $myItem, 'chantiers' => $chantiers, 'typesPieces' => $typesPieces, 'habilitations' => $habilitations, 'pieces' => $pieces, 'message' => $message, 'open' => 'entite']);
    }
	
    /**
     * Enregistre un intervenant et affiche la page de liste des intervenants
     *
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
		$user = \Auth::user();
		
        $this->validate($request, ['nom' => 'required']);

        $myItem = new Entite;
        $myItem->name = trim($request->input("nom")." ".$request->input("prenom"));
        $myItem->nom = $request->input("nom");
        $myItem->prenom = $request->input("prenom");
        $myItem->categorie = "intervenant";
        $myItem->societe = $user->societeID;
        $myItem->date_naissance = $request->input("date_naissance");
     
        $myItem->save();
		
		return $this->intervenants();
    }
	
    public function save_new(Request $request)
    {
		$user = \Auth::user();
		
        $this->validate($request, ['nom' => 'required']);
		$societe = Societe::find($user->societeID);

        $myItem = new Entite;
        $myItem->name = trim($request->input("nom")." ".$request->input("prenom"));
        $myItem->nom = $request->input("nom");
        $myItem->prenom = $request->input("prenom");
        $myItem->date_naissance = $request->input("date_naissance");
        $myItem->lieu_naissance = $request->input("lieu_naissance");
        $myItem->fonction = $request->input("fonction");
        $myItem->adresse = $request->input("adresse");
        $myItem->telephone = $request->input("telephone");
        $myItem->date_embauche = $request->input("date_embauche");
        $myItem->categorie = "intervenant";
        $myItem->nature = ($societe->temporaire) ? "interim" : "intervenant";
        $myItem->societe = $user->societeID;
        
		$pays = Pays::find($request->nationalite);
		$myItem->pays = $request->nationalite;
		$myItem->zone_entite = $pays->zone;
        if($pays->zone <> 1)
			$myItem->nature = "etranger";
		
		$pays_societe = Pays::find($societe->pays);
		$myItem->zone_entreprise = $pays_societe->zone;
        $myItem->societe = $user->societeID;
     
        $myItem->save();
		
		return $this->show($myItem->id, "USER_CREATED");
    }
	
    /**
     * Enregistre un intervenant et affiche la page de liste des intervenants
     *
     * @return \Illuminate\Http\Response
     */
    public function savevehicule(Request $request)
    {
		$user = \Auth::user();
		
        $this->validate($request, ['immatriculation' => 'required']);

        $myItem = new Entite;
        $myItem->name = $request->input("immatriculation");
        $myItem->immatriculation = $request->input("immatriculation");
        $myItem->modele = $request->input("modele");
        $myItem->marque = $request->input("marque");
        $myItem->type_vehicule = $request->input("type_vehicule");
        $myItem->categorie = "vehicule";
        $myItem->societe = $user->societeID;
     
        $myItem->save();
		
		return $this->vehicules();
    }
	
    /**
     * Enregistre un intervenant et affiche la page de liste des intervenants
     *
     * @return \Illuminate\Http\Response
     */
    public function change(Request $request)
    {
		$user = \Auth::user();
		
        $this->validate($request, ['nom' => 'required']);

        $myItem = Entite::find($request->input("id"));
        $myItem->name = trim($request->input("nom")." ".$request->input("prenom"));
        $myItem->nom = $request->input("nom");
        $myItem->prenom = $request->input("prenom");
        $myItem->adresse = $request->input("adresse");
        $myItem->fonction = $request->input("fonction");
        $myItem->date_naissance = $request->input("date_naissance");
        $myItem->adresse = $request->input("adresse");
        $myItem->telephone = $request->input("telephone");
        $myItem->date_embauche = $request->input("date_embauche");
        
		if($request->pays <> $myItem->pays)
		{
			$pays = Pays::find($request->pays);
			$myItem->pays = $request->pays;
			$myItem->zone_entite = $pays->zone;
		}
		
		if($myItem->zone_entite <> 1)
		{
			$myItem->nature = "etranger";
		}
     
        $myItem->save();
		
		return $this->show($myItem->id, "USER_MODIFIED");
    }
	
    /**
     * Enregistre un intervenant et affiche la page de liste des intervenants
     *
     * @return \Illuminate\Http\Response
     */
    public function vehiculechange(Request $request)
    {
		$user = \Auth::user();
		
        $this->validate($request, ['immatriculation' => 'required']);

        $myItem = Entite::find($request->input("id"));
        $myItem->name = $request->input("immatriculation");
        $myItem->immatriculation = $request->input("immatriculation");
        $myItem->modele = $request->input("modele");
        $myItem->marque = $request->input("marque");
        $myItem->type_vehicule = $request->input("type_vehicule");
     
        $myItem->save();
		
		return $this->vehicules();
    }
	
    public function delete($id)
    {
		$user = \Auth::user();
		
       	$myItem = Entite::find($id);

        $myItem->statut = 'deleted';
     
        $myItem->save();
		
		return $this->intervenants();
    }
	
    public function deleteelement(Request $request)
    {
		$user = \Auth::user();
		
       	$myItem = Entite::find($request->input("id"));
        $myItem->delete();
		
		return $this->intervenants();
    }
	
	public function addpiece2(Request $request)
	{
		$entite = Entite::find($request->input("id"));
		
		if(Piece::where('type_piece', $request->input("type_piece"))->where('entite', $request->input("id"))->doesntExist())
		{
			$myPiece = new Piece();
			$myPiece->type_piece = $request->input("type_piece");
			$myPiece->entite = $request->input("id");
			$myPiece->date_expiration = $request->input("date_expiration");
		
			// SI ON A UNE PIECE ATTACHEE ON LA MET ICI
			if ($request->hasFile('piece'))
			{
				$name = $request->piece->getClientOriginalName();
				$error = $request->piece->move("pieces/".$entite->societe."/".$entite->id, $name);
				$myPiece->chemin = "pieces/".$entite->societe."/".$entite->id."/".$name;
				$myPiece->extension = $request->piece->getClientOriginalExtension();
				switch(strtolower($myPiece->extension))
				{
					case "pdf" :
					case "png" :
					case "gif" :
					case "jpg" :
					case "jpeg" :
					case "tiff" :
					case "heic" :
					case "bmp" :
					// DO NOTHING
						$myPiece->save();
						break;
					default :
						return $this->showEntite($request->input("id"), $message = "WRONG_FORMAT");
						break;
				}
			
				$lesDos = DB::table('equipiers')
								->where('intervenant', $entite->id)
					            ->distinct()
								->get('equipiers.do');
				foreach($lesDos as $do)
				{
					$entite->chargerPiece($do->do, $request->input("type_piece"));
				}
			
				return $this->showEntite($entite->id, "OK_ADDED");
			}
			else
			{
				// DO NOTHING FOR NOW
				return $this->showEntite($entite->id, "ERROR_MISSING");
			}
		}
		else
		{
			$myPiece = new Piece();
			$myPiece->type_piece = $request->input("type_piece");
			$myPiece->entite = $request->input("id");
			$myPiece->date_expiration = $request->input("date_expiration");
		
			// SI ON A UNE PIECE ATTACHEE ON LA MET ICI
			if ($request->hasFile('piece'))
			{
				$name = $request->piece->getClientOriginalName();
				$error = $request->piece->move("pieces/".$entite->societe."/".$entite->id, $name);
				$myPiece->chemin = "pieces/".$entite->societe."/".$entite->id."/".$name;
				$myPiece->extension = $request->piece->getClientOriginalExtension();
				switch(strtolower($myPiece->extension))
				{
					case "pdf" :
					case "png" :
					case "gif" :
					case "jpg" :
					case "jpeg" :
					case "tiff" :
					case "heic" :
					case "bmp" :
						// DO NOTHING
						$piece = Piece::where('type_piece', $request->input("type_piece"))->where('entite', $request->input("id"))->first();
						$piece->delete();
			
						$myPiece->save();
						break;
					default :
						return $this->showEntite($request->input("id"), $message = "WRONG_FORMAT");
						break;
				}
			
				$lesDos = DB::table('equipiers')
								->where('intervenant', $entite->id)
					            ->distinct()
								->get('equipiers.do');
				foreach($lesDos as $do)
				{
					$entite->chargerPiece($do->do, $request->input("type_piece"));
				}
			
				return $this->showEntite($entite->id, "OK_ADDED");
			}
			else
			{
				// DO NOTHING FOR NOW
				return $this->showEntite($entite->id, "ERROR_MISSING");
			}
		}
		
	}	
	
	public function deletepiece(Request $request)
    {
		$myItem = Piece::find($request->input("id"));
		$myItem->delete();
    }
	
	public function deletepiece2($piece_ID)
    {
		$myItem = Piece::find($piece_ID);
		$entite = Entite::find($myItem->entite);
		
		$intervenant = $myItem->entite;
		
		$myItem->delete();
		
		if($entite->categorie == "autre")
			return $this->showEntite($intervenant);
		else
			return $this->show($intervenant);
    }
	
	public function store()
	{
		Storage::put('intervenants/7/1/archive.zip', $contents, 'public');
	}
	
	public function download($id)
    {
		$myItem = Entite::find($id);
		//Storage::put('intervenants/7/1/archive.zip', "plop", 'private');
		try {
			return Storage::download("intervenants/".$myItem->societeID."/".$myItem->id."/archive.zip", "pieces_".$myItem->nom.".zip");
	    } catch (FileNotFoundException $e) {
	           return $this->show($id, "FILE_NOT_FOUND");
	    }
    }
	
    public function restore($id)
    {
		$user = \Auth::user();
		
       	$myItem = Entite::find($id);

        $myItem->statut = 'actif';
     
        $myItem->save();
		
		return $this->intervenants();
    }
	
    public function afficherpiece(Request $request)
    {
		$user = \Auth::user();
		
       	$myPiece = Piece::find($request->input("id"));
		
		if(file_exists(public_path($myPiece->chemin)))
		{
			$key = $myPiece->chemin;
			copy(public_path($myPiece->chemin), public_path("temp/".md5($key).".".$myPiece->extension));
		}
		else
		{
			$key = $myPiece->chemin;
			echo "Not copied : ".public_path($myPiece->chemin);
		}
		
		return view('intervenant/piece', ['user' => $user, 'piece' => $myPiece, 'key' => md5($key)]);
    }
	
    public function refreshlistepieces(Request $request)
    {
		$user = \Auth::user();
		$chantier = Chantier::find($request->chantier);
		$equipier = Equipier::find($request->entite);
		$entite = Entite::find($equipier->intervenant);
	
       	$typesPiece = $chantier->pieces_chantier($entite->nature);
		return view('intervenant/listePiecesChantier', ['user' => $user, 'typesPiece' => $typesPiece]);
    }
		
    public function rechargerpiece(Request $request)
    {
		$user = \Auth::user();
		
       	$entite = Entite::find($request->input("entite"));
       	$do = $request->input("do");
       	$typePiece = $request->input("typePiece");

		$res = $entite->chargerPiece($do, $request->input("typePiece"));
		echo ($res === false) ? '<span><i class="fa text-danger fa-times-circle"> Chargement impossible, pièce validée</span>' : '<span><i class="fa fa-check"> Chargement OK</span>';
    }
	
    public function addpiece(Request $request)
    {
		$user = \Auth::user();
		
		$entite = $myItem = Entite::find($request->id);

		// ON VERIFIE QU'ON A PAS DEJA UNE PIECE DE CE TYPE EN BASE
		if(Piece::where('type_piece', $request->input("type_piece"))->where('do', NULL)->where('entite', $request->input("id"))->doesntExist())
		{
			$myPiece = new Piece;
			$myPiece->entite = $request->input("id");
			$myPiece->libelle = $request->input("libelle");
			$myPiece->chemin = $request->input("file_ID");
			$myPiece->type_piece = $request->input("type_piece");
			$myPiece->date_expiration = $request->input("date_expiration");
	
			if ($request->hasFile('fichier'))
			{
				$name = $request->fichier->getClientOriginalName();
				$error = $request->fichier->move("pieces/".$entite->societe."/".$entite->id, $name);
				$myPiece->chemin = "pieces/".$entite->societe."/".$entite->id."/".$name;
				$myPiece->extension = $request->fichier->getClientOriginalExtension();
				switch(strtolower($myPiece->extension))
				{
					case "pdf" :
					case "png" :
					case "gif" :
					case "jpg" :
					case "jpeg" :
					case "tiff" :
					case "heic" :
					case "bmp" :
					// DO NOTHING
						$myPiece->save();
						break;
					default :
						return ($entite->categorie == "vehicule") ? $this->vehiculeshow($myItem->id, "WRONG_FORMAT") : $this->show($myItem->id, "WRONG_FORMAT");
						break;
				}
				
				$lesDos = DB::table('equipiers')
								->where('intervenant', $entite->id)
					            ->distinct()
								->get('equipiers.do');
				foreach($lesDos as $do)
				{
					// ON VERIFIE SI LA PIECE EST OBLIGATOIRE CHEZ LE DO
					$myDo = Societe::find($do->do);
					if($myDo)
					{
						$pieces_oblig = $myDo->pieces_oblig($entite->nature, $request->id);
						$lesPieces = array();
						foreach($pieces_oblig as $key => $p)
							$lesPieces[$key] = $key;

						if(in_array($request->input("type_piece"), $lesPieces))
						{
							if($entite->getStatutPiece($request->input("type_piece"), $do->do) != 'valide')
								$entite->chargerPiece($do->do, $request->input("type_piece"));
						}	
					}
				}
				
		        return ($entite->categorie == "vehicule") ? $this->vehiculeshow($myItem->id, "OK_ADDED") : $this->show($myItem->id, "OK_ADDED");
			}
			else
			{
				return ($entite->categorie == "vehicule") ? $this->vehiculeshow($myItem->id, "ERROR_MISSING") : $this->show($myItem->id, "ERROR_MISSING");
			}
		}
		else
		{
			$user = \Auth::user();
		
		    $myPiece = new Piece;
	        $myPiece->entite = $request->input("id");
	        $myPiece->chemin = $request->input("file_ID");
	        $myPiece->type_piece = $request->input("type_piece");
	        $myPiece->date_expiration = $request->input("date_expiration");
	
			if ($request->hasFile('fichier'))
			{
				$name = $request->fichier->getClientOriginalName();
				$error = $request->fichier->move("pieces/".$entite->societe."/".$entite->id, $name);
				$myPiece->chemin = "pieces/".$entite->societe."/".$entite->id."/".$name;
				$myPiece->extension = $request->fichier->getClientOriginalExtension();
				switch(strtolower($myPiece->extension))
				{
					case "pdf" :
					case "png" :
					case "gif" :
					case "jpg" :
					case "jpeg" :
					case "tiff" :
					case "heic" :
					case "bmp" :
					// DO NOTHING
				       	$myPiece_old = Piece::where('type_piece', $request->input("type_piece"))->where('do', NULL)->where('entite', $request->input("id"))->first();
						$myPiece_old->delete();
			
						$myPiece->save();
						break;
					default :
						return ($entite->categorie == "vehicule") ? $this->vehiculeshow($myItem->id, "WRONG_FORMAT") : $this->show($myItem->id, "WRONG_FORMAT");
						break;
				}
				
				$lesDos = DB::table('equipiers')
								->where('intervenant', $entite->id)
					            ->distinct()
								->get('equipiers.do');
				foreach($lesDos as $do)
				{
					// ON VERIFIE SI LA PIECE EST OBLIGATOIRE CHEZ LE DO
					$myDo = Societe::find($do->do);
					if($myDo)
					{
						$pieces_oblig = $myDo->pieces_oblig($entite->nature, $request->id);
						
						$lesPieces = array();
						foreach($pieces_oblig as $key => $p)
							$lesPieces[$key] = $key;
					
						if(in_array($request->input("type_piece"), $lesPieces))
						{
							if($entite->getStatutPiece($request->input("type_piece"), $do->do) != 'valide')
								$entite->chargerPiece($do->do, $request->input("type_piece"));
						}	
					}
				}
				
		        return ($entite->categorie == "vehicule") ? $this->vehiculeshow($myItem->id, "OK_ADDED") : $this->show($myItem->id, "OK_ADDED");
			}
			else
			{
				return ($entite->categorie == "vehicule") ? $this->vehiculeshow($myItem->id, "ERROR_MISSING") : $this->show($myItem->id, "ERROR_MISSING");
			}
		}
    }
	
    public function addhabilitation(Request $request)
    {
		$user = \Auth::user();
		
       	$entite = $myItem = Entite::find($request->input("entite"));

		// ON VERIFIE QU'ON A PAS DEJA UNE HABILITATION DE CE TYPE EN BASE
		
		if(EntiteHabilitation::where('habilitation', $request->input("habilitation"))->where('entite', $request->input("entite"))->doesntExist())
		{
	        $myHabilitation = new EntiteHabilitation;
	        $myHabilitation->entite = $request->input("entite");
	        $myHabilitation->habilitation = $request->input("habilitation");
			$myHabilitation->save();
		}
		else
		{
			$myHab_old = EntiteHabilitation::where('habilitation', $request->input("habilitation"))->where('entite', $request->input("entite"))->first();
			$myHab_old->delete();
		}
    }
	
    public function getinfo(Request $request)
    {
		$user = \Auth::user();
		
       	$myItem = Entite::find($request->input("id"));
		if($myItem == NULL)
			return "Inconnu";
		
		$field = $request->input("field");
		
		$res = $myItem->$field;
		
		return $res;
    }
	
    public function rechercher(Request $request)
    {
		$user = \Auth::user();
		
		$html = '';
		
		$jumeau = Entite::where("nom", $request->nom)->where("prenom", $request->prenom)->where("date_naissance", date("Y-m-d", strtotime($request->dateNaissance)))->first();
	
		if($jumeau)
		{
			$html .= '<label class="col-form-label col-lg-2 col-sm-12">Correspondance trouvée</label>
			<div class="col-6">
				<span class="kt-switch">
					<label>
						<input type="checkbox" name="jumeau" value="'.$jumeau->id.'">
					</label>
				</span>
			</div>';
		}
		
		
		return $html;
	}
}