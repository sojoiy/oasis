<?php

namespace App\Http\Controllers;

use App\Action;
use App\Autorisation;
use App\Chantier;
use App\ChantierDo;
use App\CopiesDo;
use App\Creneau;
use App\Document;
use App\DoChantier;
use App\Entite;
use App\EntiteHabilitation;
use App\Equipier;
use App\Livreur;
use App\EquipierDo;
use App\Evenement;
use App\Habilitation;
use App\Justificatif;
use App\Livraison;
use App\Lien;
use App\Delegation;
use App\Notification;
use App\Mail\NewLivraison;
use App\Mail\NewLivraison2;
use App\Piece;
use App\Profil;
use App\Rendezvous;
use App\Societe;
use App\Service;
use App\Titulaire;
use App\TypePiece;
use App\TypeChantier;
use App\TypeLivraison;
use App\TypeEntite;
use App\Transporteur;
use App\User;
use App\Mail\NewChantier;
use App\Mail\NewChantier2;
use App\Validation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use League\Flysystem\FileNotFoundException;
use Illuminate\Support\Facades\File; 
use PDF;

class LivraisonsController extends Controller
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
	
    public function index()
    {
        return view('users');
    }
	
	// AFFICHE LA LISTE DES LIVRAISONS ENVOYE PAR LE DO OU LE PRESTA
	// livraisons/lister
    public function lister($message = "EMPTY", Request $request)
    {
		$user = \Auth::user();
		
		$societe = Societe::find($user->societeID);
		
        $page_title = 'Livraison';
        $page_description = "Mes Livraisons";
		
		$keywords = "";
		$num_page = (isset($request->num_page)) ? $request->input("num_page") : 1;
		$sort = (isset($request->sort)) ? $request->input("sort") : "libelle";
		$sens = (isset($request->sens)) ? $request->input("sens") : "asc";
		$refresh = "/livraisons/lister";
		
		if(isset($request->keywords) && $request->keywords != "")
		{
			$keywords = $request->keywords;
			
			if($user->do)
			{
				$elements = Livraison::where('do', $user->societeID)->where('date_livraison', '>=', date("Y-m-d"))->where('libelle', 'like', '%'.$request->keywords.'%')->orWhere('numero', 'like', '%'.$request->keywords.'%')->orderBy($sort, $sens)->offset(($num_page-1)*20)->limit(20)->get();
				$nb_items = Livraison::where('do', $user->societeID)->where('date_livraison', '>=', date("Y-m-d"))->where('libelle', 'like', '%'.$request->keywords.'%')->orWhere('numero', 'like', '%'.$request->keywords.'%')->count();
			}	
			else
			{
				$elements = Livraison::where('societe', $user->societeID)->where('type_chantier', 0)->where('date_livraison', '>=', date("Y-m-d"))->where('libelle', 'like', '%'.$request->keywords.'%')->orWhere('numero', 'like', '%'.$request->keywords.'%')->orderBy($sort, $sens)->offset(($num_page-1)*20)->limit(20)->get();
				$nb_items = Livraison::where('societe', $user->societeID)->where('date_livraison', '>=', date("Y-m-d"))->where('type_chantier', 0)->where('libelle', 'like', '%'.$request->keywords.'%')->orWhere('numero', 'like', '%'.$request->keywords.'%')->count();
			}
			
			$nb_pages = max(1, intval($nb_items/20));
		}
		else
		{
			if($user->do)
			{
				$elements = Livraison::where('do', $user->societeID)->where('date_livraison', '>=', date("Y-m-d"))->orderBy($sort, $sens)->offset(($num_page-1)*20)->limit(20)->get();
				$nb_items = Livraison::where('do', $user->societeID)->where('date_livraison', '>=', date("Y-m-d"))->where('libelle', 'like', '%'.$request->keywords.'%')->count();
			}	
			else
			{
				$elements = Livraison::where('societe', $user->societeID)->where('type_chantier', 0)->where('date_livraison', '>=', date("Y-m-d"))->orderBy($sort, $sens)->offset(($num_page-1)*20)->limit(20)->get();
				$nb_items = Livraison::where('societe', $user->societeID)->where('date_livraison', '>=', date("Y-m-d"))->where('type_chantier', 0)->where('libelle', 'like', '%'.$request->keywords.'%')->count();
			}
			
			$nb_pages = max(1, intval($nb_items/20));
		}	
		
		// BOUTONS D'ACTIONS
		$actions = array();
		$actions[] = array("url" => "/chantier/create/", "label" => "Nouveau chantier", "style" => "info", "icon" => "<i class='fa fa-plus'></i>");
		
        return view('livraisons/lister', compact('page_title', 
		'page_description', 
		'refresh',
		'actions', 
		'user', 
		'keywords', 
		'nb_pages', 
		'societe', 
		'num_page', 
		'sort', 
		'sens', 
		'elements',
		'nb_items')); 
    }
	
	public function createlivraison(Request $request, $message = "EMPTY")
    {
		$user = \Auth::user();
		
		$typeChantiers = TypeLivraison::all();
		$infos = array();
		$infos["numero"] = ($request->input("numero")) ? $request->input("numero") : '';
		$infos["libelle"] = ($request->input("libelle")) ? $request->input("libelle") : '';
		$infos["date_livraison"] = ($request->input("date_livraison")) ? $request->input("date_livraison") : '';
		$infos["recurrence"] = ($request->input("recurrence")) ? $request->input("recurrence") : '';
			
        return view('livraisons/create', ['user' => $user, 'infos' => $infos, 'typeChantiers' => $typeChantiers, 'message' => $message, 'open' => 'livraisons']);
    }
	
	public function save(Request $request)
    {
		$user = \Auth::user();
		
        $this->validate($request, ['numero' => 'required']);

		if(Livraison::where('numero', $request->input("numero"))->where('do', $user->societeID)->doesntExist())
		{
	        $myItem = new Livraison;
	        $myItem->numero = $request->input("numero");
	        $myItem->initiateur = $user->id;
	        $myItem->libelle = $request->input("libelle");
	        $myItem->date_livraison = $request->input("date_livraison");
	        $myItem->recurrence = $request->input("recurrence");
	        $myItem->do = $user->societeID;
	        $myItem->type_chantier = $request->input("typeChantier");

	        $myItem->save();

			return $this->show($myItem->id);
		}
		else
		{
			$infos = array();
			$infos["numero"] = $request->input("numero");
			$infos["libelle"] = $request->input("libelle");
			$infos["date_livraison"] = $request->input("date_livraison");
			$infos["recurrence"] = $request->input("recurrence");
			
			return $this->createlivraison($request, $infos, "ITEM_EXISTS");
		}
    }
	
	public function show($id)
    {
		$user = \Auth::user();
		
		$livraison = Livraison::find($id);
		
		// SI LE DOSSIER N'A PAS DE PRESTATAIRE PRINCIPAL ON LE REDIRIGE
		if(!$livraison->societe)
		{
			return $this->choixpresta($id);
		}
			
		$transporteurs = Transporteur::where('livraison', $id)->get();
		$titulaire = Societe::find($livraison->societe);
		$prestataires = Societe::where('transport', 1)->get();
			
        return view('livraisons/show', ['user' => $user, 'livraison' => $livraison, 'titulaire' => $titulaire, 'transporteurs' => $transporteurs, 'open' => 'livraisons']);
    }
	
	public function choixpresta($id)
	{
		$user = \Auth::user();
		
		$livraison = Livraison::find($id);
		
		$transporteurs = Transporteur::where('livraison', $id)->get();
		$prestataires = Societe::where('transport', 1)->get();
		
		return view('livraisons/choixpresta', ['user' => $user, 'prestataires' => $prestataires, 'livraison' => $livraison, 'transporteurs' => $transporteurs, 'open' => 'livraisons']);
	}
	
	public function rechercherpresta(Request $request)
    {
		$user = \Auth::user();
		
		$prestataires = Societe::where('id', '<>', $user->societeID)->where('transport', 1)->where('raisonSociale', 'like', '%'.$request->input("keywords").'%')->get();
		
		return view('livraisons/liste-presta', ['user' => $user, 'prestataires' => $prestataires, 'open' => 'chantier']);
    }
	
	public function addpresta(Request $request)
    {
		$user = \Auth::user();
		
		$myLivraison = Livraison::find($request->input("livraisonID"));
		
		// SI LA SOCIETE EST A 0 ON VA LA CREER
		if($request->input("mandataireID") == 0)
		{
			$societe = new Societe;
			$societe->raisonSociale = $request->input("raisonSociale");
			$societe->noSiret = $request->input("noSiret");
			$societe->email = $request->input("emailDirigeant");
			$societe->autre_email = $request->input("autreEmail");
			
			$societe->save();
		}
		else
		{
			$societe = Societe::find($request->input("mandataireID"));
		}
			
		// SI C'EST LE TITULAIRE PRINCIPAL DE LA COMMANDE ON LE MET DANS LE DOSSIER SINON ON LE RAJOUTE DANS LE MANDAT
		if($request->input("titulaire"))
		{
			$myLivraison->societe = $societe->id;
			$myLivraison->save();
			
	        try
			{
		        $transporteur = new Transporteur;
		        $transporteur->livraison = $request->input("livraisonID");
		        $transporteur->societe = $societe->id;
				$transporteur->save();
				
			} catch (\Exception $e) {
				return view('message/notify', ['type' => 'danger', 'icon' => 'fa-exclamation-triangle', 'message' => 'Ce prestataire est déjà affecté à ce dossier']);
			}
		}
		else
		{
	        try
			{
		        $transporteur = new Transporteur;
		        $transporteur->livraison = $request->input("livraisonID");
		        $transporteur->societe = $societe->id;
				$transporteur->save();
				
			} catch (\Exception $e) {
				return view('message/notify', ['type' => 'danger', 'icon' => 'fa-warning', 'message' => 'Ce prestataire est déjà affecté à ce dossier']);
			}
		}
		
		// ON NOTIFIE LE PRESTA PAR MAIL
		if($request->input("mandataireID") == 0)
			$res = Mail::to($request->input("emailDirigeant"))->send(new NewLivraison2($myLivraison, $societe));
		else
			$res = Mail::to($request->input("emailDirigeant"))->send(new NewLivraison($myLivraison));
				
		$titulaires = Transporteur::where('livraison', $request->input("livraisonID"))->get();
		$prestataires = Societe::where('id', '<>', $user->societeID)->where('transport', 1)->get();
		
		return view('message/notify', ['type' => 'success', 'icon' => 'fa-check', 'message' => 'Prestataire ajouté']);
	}
	
	public function supprimerpresta(Request $request)
	{
		$user = \Auth::user();
	
		$myItem = Transporteur::find($request->input("id"));
		$myLivraison = Livraison::find($myItem->livraison);
		$myItem->delete();
		
		$transporteurs = Transporteur::where('livraison', $myLivraison->id)->get();
		$prestataires = Societe::where('deleted', 0)->where('transport', 1)->get();
		
		return view('livraisons/liste-titu', ['user' => $user, 'livraison' => $myLivraison, 'prestataires' => $prestataires, 'transporteurs' => $transporteurs, 'open' => 'livraison']);
	}
    public function documents($id)
    {
		$user = \Auth::user();
		$societe = Societe::find($user->societeID);
		$societeID = $user->societeID;
		
		$categorie = "livreur";
		
		$myLivraison = Livraison::find($id);
		$livraison = $myLivraison->id;
		$transporteurs = Transporteur::where('livraison', $myLivraison->id)->get();
		
        return view('livraisons/documents', ['user' => $user, 
		'livraison' => $myLivraison, 
		'open' => 'livraison',
		'transporteurs' => $transporteurs]);
    }
	
	public function ajouterdocument(Request $request)
	{
		$user = \Auth::user();
		$livraison = Livraison::find($request->input("livraison"));
		$societe = $request->input("societe");
		
        $myPiece = new Piece;
        $myPiece->livraison = $request->input("livraison");
        $myPiece->do = $livraison->do;
        $myPiece->societe = $request->input("societe");
        $myPiece->type_piece = $request->input("type_piece");
        $myPiece->date_expiration = $request->input("date_expiration");

		if ($request->hasFile('fichier'))
		{
			$name = $request->fichier->getClientOriginalName();
			$error = $request->fichier->move("pieces/".$societe."/0", $name);
			$myPiece->chemin = "pieces/".$societe."/0/".$name;
			$myPiece->extension = $request->fichier->getClientOriginalExtension();

			$myPiece->save();
		}
		else
		{
		
		}
		
		return $this->documents($request->input("livraison"));
	}
	
    public function intervenants($id)
    {
		$user = \Auth::user();
		$societe = Societe::find($user->societeID);
		$societeID = $user->societeID;
		
		$categorie = "livreur";
		
		$myItem = Livraison::find($id);
		$livraison = $myItem->id;
		
		if($myItem->do == $user->societeID)
		{
			$titulaire = Societe::find($myItem->societe);
			$equipe = Livreur::where('livraison', $id)->whereIn('categorie', ['livreur'])->get();
			$remplacants = array();
		}
		else
		{
			$titulaire = Societe::find($user->societeID);
			$remplacants = DB::table('entites')
				->where('societe', $user->societeID)
				->whereIn('categorie', ['intervenant', 'interim', 'etranger'])
				->whereNotIn('id', function($query) use ($livraison)
				    {
				        $query->select(DB::raw('intervenant'))
				              ->from('livreurs')
				              ->whereRaw('livreurs.livraison = '.$livraison);
				    })
	            ->get('entites.*');

			$equipe = Livreur::where('livraison', $id)->where('societe', $user->societeID)->whereIn('categorie', ['livreur'])->get();
		}
		
        return view('livraisons/intervenants', ['user' => $user, 
		'equipe' => $equipe, 
		'remplacants' => $remplacants, 
		'titulaire' => $titulaire, 
		'livraison' => $myItem, 
		'open' => 'livraison', 
		'categorie' => $categorie]);
    }
	
    public function vehicules($id)
    {
		$user = \Auth::user();
		
		$societeID = $user->societeID;
		
		$myItem = Livraison::find($id);
		
		if($myItem->do == $user->societeID)
		{
			$titulaire = Societe::find($myItem->societe);
			$remplacants = array();

			$vehicules = Livreur::where('livraison', $id)->where('categorie', 'vehicule')->get();
		}
		else
		{
			$titulaire = Societe::find($user->societeID);
			$remplacants = DB::table('entites')
				->where('societe', $user->societeID)
				->where('categorie', 'vehicule')
				->whereNotIn('id', function($query) use ($chantierID)
				    {
				        $query->select(DB::raw('intervenant'))
				              ->from('equipiers')
				              ->whereRaw('equipiers.chantier = '.$chantierID);
				    })
	            ->get('entites.*');

			$vehicules = Equipier::where('chantier', $chantierID)->where('societe', $user->societeID)->where('categorie', 'vehicule')->get();
		}
		
        return view('livraisons/vehicules', ['user' => $user, 'vehicules' => $vehicules, 'remplacants' => $remplacants, 'titulaire' => $titulaire, 'livraison' => $myItem, 'open' => 'chantier']);
    }
	
	public function liste_titulaires(Request $request)
    {
		$user = \Auth::user();
		
		$myLivraison = Livraison::find($request->input("id"));
		$transporteurs = Transporteur::where('livraison', $request->input("id"))->get();
		$prestataires = Societe::where('deleted', 0)->where('transport', 1)->get();
		
		return view('livraisons/liste-titu', ['user' => $user, 'livraison' => $myLivraison, 'prestataires' => $prestataires, 'transporteurs' => $transporteurs, 'open' => 'livraison']);
    }
	
    public function mandats($id)
    {
		$user = \Auth::user();
		
		$myItem = Livraison::find($id);
		
		$titulaire = Societe::find($myItem->societe);
		$transporteurs = Transporteur::where('livraison', $id)->get();
		
        return view('livraisons/mandats', ['user' => $user, 'titulaire' => $titulaire, 'transporteurs' => $transporteurs, 'livraison' => $myItem, 'open' => 'chantier']);
    }
	
	/*** GESTION DES MANDATS ***/
    public function voirmandat(Request $request)
    {
		$user = \Auth::user();
		
		$myItem = Delegation::find($request->input("id"));
		
        return view('livraisons/detailmandat', ['user' => $user, 'mandat' => $myItem, 'open' => 'chantier']);
    }
	
	
	public function creermandat(Request $request)
    {
		$user = \Auth::user();
	
        try
		{
			$myItem = new Mandat;
			
			if($request->input("mandataireID") == 0)
			{
				$societe = new Societe;
		        $societe->raisonSociale = $request->input("rs");
		        $societe->noSiret = $request->input("siret");
		        $societe->email = $request->input("email");
		        $societe->autre_email = $request->input("autre_email");
		        $societe->temporaire = ($request->input("agence_interim") == "on") ? 1 : 0;
				$societe->save();
				$myItem->mandataire = $societe->id;
			}
			else
			{
		        $myItem->mandataire = $request->input("mandataireID");
			}
	        
	        $myItem->chantier = $request->input("chantierID");
	        $myItem->societe = $request->input("societeID");
	        $myItem->date_debut = $request->input("date_debut");
	        $myItem->date_fin = $request->input("date_fin");
	        $myItem->save();
			
			return $this->show($request->input("chantierID"));
		} catch (\Exception $e) {
			return $this->show($request->input("chantierID"), "ALREADY_EXISTS");
		}
    }
	
	// COTE PRESTA
    public function received($message = "EMPTY")
    {
		$user = \Auth::user();
		
		$myItem = Societe::find($user->societeID);
		$societeID = $user->societeID;
		$results = Transporteur::where('societe', $user->societeID)->get();
				
		$active_chantiers = array();
		foreach($results as $result)
		{
			$livraison = Livraison::find($result->livraison);
			if($livraison->type_chantier <> 0)
				$active_chantiers[] = $livraison;
		}
			
		$results = Delegation::where('mandataire', $user->societeID)->get();
		foreach($results as $result)
		{
			$active_chantiers[] = Livraison::find($result->livraison);
		}
		
		return view('livraisons/sent', ['user' => $user, 'societe' => $myItem, 'livraisons' => $active_chantiers, 'message' => $message, 'open' => 'livraison', 'sens' => 'Dossiers reçus']);
    }
	
    public function ajouterlivreur(Request $request)
    {
		$user = \Auth::user();
		
		$chantierID = $request->input("id");
		$chantier = Livraison::find($request->input("id"));
		$myEntity = Entite::find($request->input("entiteID"));
		
        $myTeammate = new Livreur;
        $myTeammate->intervenant = $request->input("entiteID");
        $myTeammate->livraison = $request->input("id");
        $myTeammate->societe = $user->societeID;
        $myTeammate->do = $chantier->do;
		
		// ON VERIFIE QUE LE GARS EST BIEN DANS LA LISTE GLOBALE
		$myEntity->checkListeDo($chantier->do);
		
		// CAS DES VEHICULES SI C'EST EN UN ON PREND QUE LA CG
		if($myEntity->categorie == "vehicule")
		{
			// ON RECUPERE LE TYPE DE PIECES NECESSAIRE POUR LE DOSSIER
			$piecesNeeded = array();
	        
			$myTeammate->categorie = "vehicule";
	        $myTeammate->save();
			
			$myEntity->chargerPieces($chantier->do);
			
	        $equipe = Livreur::where('livraison', $chantierID)->where('societe', $user->societeID)->where('categorie', 'vehicule')->get();
		}
		else
		{
			$societe = Societe::find($user->societeID);
			$myTeammate->categorie = "livreur";
			$myTeammate->save();
			
			// ON VA RECUPERER LES PIECES ET LES METTRE CHEZ LE DO
			$myEntity->chargerPieces($chantier->id);

	        $equipe = Livreur::where('livraison', $chantierID)->where('societe', $user->societeID)->whereIn('categorie', ['livreur'])->get();
		}

		return view('livraisons/equipe', ['user' => $user, 'equipe' => $equipe, 'chantier' => $chantier, 'open' => 'chantier']);
    }
	
    public function enleverequipier(Request $request)
    {
		$user = \Auth::user();
		
		$myItem = Chantier::find($request->input("id"));
		
        $myTeammate = Equipier::find($request->input("entiteID"));
        $myTeammate->delete();
		
		return '<option id="ligneEntite_'.$myTeammate->intervenant.'" value="'.$myTeammate->intervenant.'">'.$myTeammate->name().'</option>';
    }
	
}