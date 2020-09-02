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
use App\EquipierDo;
use App\Evenement;
use App\Habilitation;
use App\Justificatif;
use App\Lien;
use App\Mandat;
use App\Notification;
use App\Piece;
use App\Profil;
use App\Rendezvous;
use App\Societe;
use App\Service;
use App\Titulaire;
use App\TypePiece;
use App\TypeChantier;
use App\TypeEntite;
use App\User;
use App\Mail\NewChantier;
use App\Mail\NewChantier2;
use App\Mail\ChantierDoUrl;
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

class ChantiersController extends Controller
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
	
	
	/** AFFICHAGE DES LISTES DE CHANTIER **/
	
	// AFFICHE LA LISTE DES CHANTIERS ENVOYE PAR LE DO OU LE PRESTA
	// chantier/sent
    public function sent($message = "EMPTY", Request $request)
    {
		$user = \Auth::user();
		
		$societe = Societe::find($user->societeID);
		
        $page_title = 'Dossier';
        $page_description = "Dossier émis";
		
		$keywords = "";
		$num_page = (isset($request->num_page)) ? $request->input("num_page") : 1;
		$sort = (isset($request->sort)) ? $request->input("sort") : "libelle";
		$sens = (isset($request->sens)) ? $request->input("sens") : "asc";
		$refresh = "/chantier/sent";
		
		if(isset($request->keywords) && $request->keywords != "")
		{
			$keywords = $request->keywords;
			
			if($user->do)
			{
				$elements = Chantier::where('do', $user->societeID)->where('date_fin', '>=', date("Y-m-d"))->where('libelle', 'like', '%'.$request->keywords.'%')->orWhere('numero', 'like', '%'.$request->keywords.'%')->orderBy($sort, $sens)->offset(($num_page-1)*20)->limit(20)->get();
				$nb_items = Chantier::where('do', $user->societeID)->where('date_fin', '>=', date("Y-m-d"))->where('libelle', 'like', '%'.$request->keywords.'%')->orWhere('numero', 'like', '%'.$request->keywords.'%')->count();
			}	
			else
			{
				$elements = Chantier::where('societe', $user->societeID)->where('type_chantier', 0)->where('date_fin', '>=', date("Y-m-d"))->where('libelle', 'like', '%'.$request->keywords.'%')->orWhere('numero', 'like', '%'.$request->keywords.'%')->orderBy($sort, $sens)->offset(($num_page-1)*20)->limit(20)->get();
				$nb_items = Chantier::where('societe', $user->societeID)->where('date_fin', '>=', date("Y-m-d"))->where('type_chantier', 0)->where('libelle', 'like', '%'.$request->keywords.'%')->orWhere('numero', 'like', '%'.$request->keywords.'%')->count();
			}
			
			$nb_pages = max(1, intval($nb_items/20));
		}
		else
		{
			if($user->do)
			{
				$elements = Chantier::where('do', $user->societeID)->where('date_fin', '>=', date("Y-m-d"))->orderBy($sort, $sens)->offset(($num_page-1)*20)->limit(20)->get();
				$nb_items = Chantier::where('do', $user->societeID)->where('date_fin', '>=', date("Y-m-d"))->where('libelle', 'like', '%'.$request->keywords.'%')->count();
			}	
			else
			{
				$elements = Chantier::where('societe', $user->societeID)->where('type_chantier', 0)->where('date_fin', '>=', date("Y-m-d"))->orderBy($sort, $sens)->offset(($num_page-1)*20)->limit(20)->get();
				$nb_items = Chantier::where('societe', $user->societeID)->where('date_fin', '>=', date("Y-m-d"))->where('type_chantier', 0)->where('libelle', 'like', '%'.$request->keywords.'%')->count();
			}
			
			$nb_pages = max(1, intval($nb_items/20));
		}	
		
		// BOUTONS D'ACTIONS
		$actions = array();
		$actions[] = array("url" => "/chantier/create/", "label" => "Nouveau chantier", "style" => "info", "icon" => "<i class='fa fa-plus'></i>");
		
        return view('chantier/liste/sent', compact('page_title', 
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
	
    public function received($message = "EMPTY", Request $request)
    {
		$user = \Auth::user();
		
        $page_title = 'Dossier';
        $page_description = "Dossier reçus";
		
		$societe = Societe::find($user->societeID);
		$societeID = $user->societeID;
		$results = Titulaire::where('societe', $user->societeID)->get();
		
		$keywords = "";
		$num_page = (isset($request->num_page)) ? $request->input("num_page") : 1;
		$sort = (isset($request->sort)) ? $request->input("sort") : "libelle";
		$sens = (isset($request->sens)) ? $request->input("sens") : "asc";
		$refresh = "/chantier/received";
		
		if(isset($request->keywords) && $request->keywords != "")
		{
			$keywords = $request->keywords;
			
			if($user->do)
			{
				$results = Titulaire::where('societe', $user->societeID)->get();
				
				$elements = array();
				foreach($results as $result)
				{
					$chantier = Chantier::find($result->chantier);
					if($chantier->type_chantier <> 0)
						$elements[] = $chantier;
				}
			
				$results = Mandat::where('mandataire', $user->societeID)->get();
				foreach($results as $result)
				{
					$elements[] = Chantier::find($result->chantier);
				}
				$nb_items = Chantier::where('do', $user->societeID)->where('date_fin', '>=', date("Y-m-d"))->where('libelle', 'like', '%'.$request->keywords.'%')->count();
			}	
			else
			{
				$results = Titulaire::where('societe', $user->societeID)->get();
				
				$elements = array();
				foreach($results as $result)
				{
					$chantier = Chantier::find($result->chantier);
					if($chantier->type_chantier <> 0)
						$elements[] = $chantier;
				}
			
				$results = Mandat::where('mandataire', $user->societeID)->get();
				foreach($results as $result)
				{
					$elements[] = Chantier::find($result->chantier);
				}
				$nb_items = Chantier::where('societe', $user->societeID)->where('date_fin', '>=', date("Y-m-d"))->where('type_chantier', 0)->where('libelle', 'like', '%'.$request->keywords.'%')->count();
			}
			
			$nb_pages = max(1, intval(sizeof($nb_items)/20));
		}
		else
		{
			if($user->do)
			{
				$results = Titulaire::where('societe', $user->societeID)->get();
				
				$elements = array();
				foreach($results as $result)
				{
					$chantier = Chantier::find($result->chantier);
					if($chantier->type_chantier <> 0)
						$elements[] = $chantier;
				}
			
				$results = Mandat::where('mandataire', $user->societeID)->get();
				foreach($results as $result)
				{
					$elements[] = Chantier::find($result->chantier);
				}
				$nb_items = Chantier::where('do', $user->societeID)->where('date_fin', '>=', date("Y-m-d"))->where('libelle', 'like', '%'.$request->keywords.'%')->count();
			}	
			else
			{
				$results = Titulaire::where('societe', $user->societeID)->get();
				
				$elements = array();
				foreach($results as $result)
				{
					$chantier = Chantier::find($result->chantier);
					if($chantier->type_chantier <> 0)
						$elements[] = $chantier;
				}
			
				$results = Mandat::where('mandataire', $user->societeID)->get();
				foreach($results as $result)
				{
					$elements[] = Chantier::find($result->chantier);
				}
				$nb_items = Chantier::where('societe', $user->societeID)->where('date_fin', '>=', date("Y-m-d"))->where('type_chantier', 0)->where('libelle', 'like', '%'.$request->keywords.'%')->count();
			}
			
			$nb_pages = max(1, intval($nb_items)/20);
		}	
		
        return view('chantier/liste/sent', compact('page_title', 
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
		'nb_items')); 
    }
	
    public function virtuels($message = "EMPTY")
    {
		$user = \Auth::user();
		
		$myItem = Societe::find($user->societeID);
		$active_chantiers = Chantier::where('societe', $user->societeID)->where('categorie', 'virtuel')->limit(100)->get();
		
		return view('chantier/virtuels_presta', ['user' => $user, 'societe' => $myItem, 'chantiers' => $active_chantiers, 'message' => $message, 'sens' => 'Chantiers virtuels', 'open' => 'chantier']);
    }
	
    public function do($message = "EMPTY")
    {
		$user = \Auth::user();
		
		$myItem = Societe::find($user->societeID);
		
		$active_chantiers = ChantierDo::where('do', $user->societeID)->where('date_fin', '>', date("Y-m-d"))->orderby('date_debut')->limit(100)->get();
		
        return view('chantier/sent', ['user' => $user, 'societe' => $myItem, 'chantiers' => $active_chantiers, 'message' => $message, 'sens' => 'Dossiers DO', 'open' => 'chantier']);
    }
	
	
	/** AFFICHAGE D'UN CHANTIER **/
	
	// AFFICHE UN CHANTIER A PARTIR DE SON ID
	// chantier/show{id}
    public function show($id, $message = "EMPTY")
    {
		$user = \Auth::user();
        
		$chantier = Chantier::find($id);
		$page_title = 'Dossier '.$chantier->numero;
		$page_description = $chantier->numero;
		
		// SI LE DOSSIER N'A PAS DE PRESTATAIRE PRINCIPAL ON LE REDIRIGE
		if(!$chantier->societe)
		{
			return $this->choixpresta($id);
		}
			
		$titulaire = Societe::find($chantier->societe);
		$titulaires = Titulaire::where('chantier', $id)->get();
		$evenements = Evenement::where('chantier', $id)->get();
		
		// BOUTONS D'ACTIONS
		$actions = array();
		$actions[] = array("url" => "/chantier/show/".$chantier->id, "label" => "Informations", "style" => "info", "icon" => "<i class='fa fa-info'></i>");
		$actions[] = array("url" => "/chantier/intervenants/".$chantier->id, "label" => "Intervenants", "style" => "info", "icon" => "<i class='fa fa-user-friends'></i>");
		$actions[] = array("url" => "/chantier/vehicules/".$chantier->id, "label" => "Véhicules", "style" => "info", "icon" => "<i class='fa fa-truck'></i>");
		
		// SI ON EST UN ST DE NIV2 ON NE PEUT PAS VOIR CES BOUTONS
		
		$isTitulaire = Titulaire::where('chantier', $id)->where('societe', $user->societeID)->exists();
		if($isTitulaire)
		{
			$actions[] = array("url" => "/chantier/mandats/".$chantier->id, "label" => "Mandats", "style" => "info", "icon" => "<i class='fa fa-sitemap'></i>");
			$actions[] = array("url" => "/chantier/mandater/".$chantier->id, "label" => "Ajouter un prestataire", "style" => "info", "icon" => "<i class='fa fa-plus'></i>");
		}
		elseif($chantier->do == $user->id)
			$actions[] = array("url" => "/chantier/choixpresta/".$chantier->id, "label" => "Titulaires", "style" => "info", "icon" => "<i class='fa fa-plus'></i>");
			
		
		
		// BOUTONS DE POPUP
		$popups = array();
		$popups[] = array("target" => "kt_modal_prorogation", "icon" => "<i class='flaticon2-file text-muted'></i>");
		
		// BOUTONS DE NAVIGATION
		$navs = array();
		$navs[] = array("url" => "/chantier/sent", "label" => "Retour", "icon" => "<i class='fa fa-arrow-left'></i>");
		
        return view('chantier/affichage/show', compact('page_title', 
		'page_description', 
		'user', 
		'actions', 
		'popups',
		'navs',
		'titulaire', 
		'evenements', 
		'titulaires', 
		'chantier', 
		'message'));
    }
	
	// AFFICHE UN CHANTIER A PARTIR DE SON ID
	// chantier/intervenants/{id}
    public function intervenants($id)
    {
		$user = \Auth::user();
		$societe = Societe::find($user->societeID);
		
		$societeID = $user->societeID;
		
		$categorie = "intervenant";
		if($societe->temporaire)
			$categorie = "interim";
		
		$chantier = Chantier::find($id);
		$chantierID = $id;
		
		$page_title = 'Dossier '.$chantier->numero;
		$page_description = $chantier->numero;
		
		if($chantier->do == $user->societeID)
		{
			$titulaire = Societe::find($chantier->societe);
			$remplacants = array();

			$equipe = Equipier::where('chantier', $chantierID)->whereIn('categorie', ['intervenant'])->get();
			$equipe_int = Equipier::where('chantier', $chantierID)->whereIn('categorie', ['interim'])->get();
			$equipe_etr = Equipier::where('chantier', $chantierID)->whereIn('categorie', ['etranger'])->get();
			
			$st_int = array();
		}
		else
		{
			$titulaire = Societe::find($user->societeID);
			$remplacants = DB::table('entites')
				->where('societe', $user->societeID)
				->whereIn('categorie', ['intervenant', 'interim', 'etranger'])
				->whereNotIn('id', function($query) use ($chantierID)
				    {
				        $query->select(DB::raw('intervenant'))
				              ->from('equipiers')
				              ->whereRaw('equipiers.chantier = '.$chantierID);
				    })
	            ->get('entites.*');

			$equipe = Equipier::where('chantier', $chantierID)->where('societe', $user->societeID)->whereIn('categorie', ['intervenant'])->get();
			$equipe_int = Equipier::where('chantier', $chantierID)->where('societe', $user->societeID)->whereIn('categorie', ['interim'])->get();
			// ON VA AJOUTER LES INTERIMAIRES DES AUTRES SOCIETES
			
			$st = array();
			$sous_traitants = Mandat::where('societe', $user->societeID)->where('chantier', $id)->get();
			foreach($sous_traitants as $sous_traitant)
				$st[] = $sous_traitant->mandataire;
			
			$st_int = Equipier::where('chantier', $chantierID)->whereIn('societe', $st)->whereIn('categorie', ['interim'])->get();
			
			$equipe_etr = Equipier::where('chantier', $chantierID)->where('societe', $user->societeID)->whereIn('categorie', ['etranger'])->get();
		}
		
		$natures = array('intervenant', 'interim', 'etranger');
		
		// BOUTONS D'ACTIONS
		$actions = array();
		$actions[] = array("url" => "/chantier/show/".$chantier->id, "label" => "Informations", "style" => "info", "icon" => "<i class='fa fa-info'></i>");
		$actions[] = array("url" => "/chantier/intervenants/".$chantier->id, "label" => "Intervenants", "style" => "info", "icon" => "<i class='fa fa-user-friends'></i>");
		$actions[] = array("url" => "/chantier/vehicules/".$chantier->id, "label" => "Véhicules", "style" => "info", "icon" => "<i class='fa fa-truck'></i>");
		
		// SI ON EST UN ST DE NIV2 ON NE PEUT PAS VOIR CES BOUTONS
		
		$isTitulaire = Titulaire::where('chantier', $id)->where('societe', $user->societeID)->exists();
		if($isTitulaire)
		{
			$actions[] = array("url" => "/chantier/mandats/".$chantier->id, "label" => "Mandats", "style" => "info", "icon" => "<i class='fa fa-sitemap'></i>");
			$actions[] = array("url" => "/chantier/mandater/".$chantier->id, "label" => "Ajouter un prestataire", "style" => "info", "icon" => "<i class='fa fa-plus'></i>");
		}
		elseif($chantier->do == $user->id)
			$actions[] = array("url" => "/chantier/choixpresta/".$chantier->id, "label" => "Titulaires", "style" => "info", "icon" => "<i class='fa fa-plus'></i>");
		
		// BOUTONS DE POPUP
		$popups = array();
		$popups[] = array("target" => "kt_modal_prorogation", "icon" => "<i class='flaticon2-file text-muted'></i>");
		
		// BOUTONS DE NAVIGATION
		$navs = array();
		$navs[] = array("url" => "/chantier/sent", "label" => "Retour", "icon" => "<i class='fa fa-arrow-left'></i>");
		
        return view('chantier/affichage/intervenants', compact('page_title', 
		'page_description', 
		'user', 
		'actions', 
		'popups',
		'navs',
		'equipe', 
		'equipe_int', 
		'st_int', 
		'equipe_etr', 
		'remplacants', 
		'titulaire', 
		'chantier', 
		'categorie', 
		'natures'));
    }
	
	// AFFICHE D'UN INTERVENANT VERSION DO
	// chantier/intervenant/{id}
    public function intervenant($id)
    {
		$user = \Auth::user();
		
		$intervenant = Equipier::find($id);
		$entite = Entite::find($intervenant->intervenant);
		$chantier = Chantier::find($intervenant->chantier);
		
		$page_title = 'Dossier '.$chantier->numero;
		$page_description = $chantier->numero;
		
		$pieces = $chantiers = array();
		//Equipier::where('intervenant', $myItem->intervenant)->get();
		$copies = Piece::where('entite', $entite->id)->where('do', $chantier->do)->get();
		$habilitations = EntiteHabilitation::where('entite', $id)->get();
		
		// BOUTONS D'ACTIONS
		$actions = array();
		$actions[] = array("url" => "/chantier/show/".$chantier->id, "label" => "Informations", "style" => "info", "icon" => "<i class='fa fa-info'></i>");
		$actions[] = array("url" => "/chantier/intervenants/".$chantier->id, "label" => "Intervenants", "style" => "info", "icon" => "<i class='fa fa-user-friends'></i>");
		$actions[] = array("url" => "/chantier/vehicules/".$chantier->id, "label" => "Véhicules", "style" => "info", "icon" => "<i class='fa fa-truck'></i>");
		
		// SI ON EST UN ST DE NIV2 ON NE PEUT PAS VOIR CES BOUTONS
		
		$isTitulaire = Titulaire::where('chantier', $id)->where('societe', $user->societeID)->exists();
		if($isTitulaire)
		{
			$actions[] = array("url" => "/chantier/mandats/".$chantier->id, "label" => "Mandats", "style" => "info", "icon" => "<i class='fa fa-sitemap'></i>");
			$actions[] = array("url" => "/chantier/mandater/".$chantier->id, "label" => "Ajouter un prestataire", "style" => "info", "icon" => "<i class='fa fa-plus'></i>");
		}
		elseif($chantier->do == $user->id)
			$actions[] = array("url" => "/chantier/choixpresta/".$chantier->id, "label" => "Titulaires", "style" => "info", "icon" => "<i class='fa fa-plus'></i>");
		
		// BOUTONS DE POPUP
		$popups = array();
		$popups[] = array("target" => "kt_modal_prorogation", "icon" => "<i class='flaticon2-file text-muted'></i>");
		
		// BOUTONS DE NAVIGATION
		$navs = array();
		$navs[] = array("url" => "/chantier/sent", "label" => "Retour", "icon" => "<i class='fa fa-arrow-left'></i>");
		
        return view('chantier/affichage/intervenant', compact('page_title', 
		'page_description', 
		'user', 
		'actions', 
		'popups',
		'navs',
		'entite', 
		'intervenant', 
		'chantier', 
		'pieces', 
		'chantiers', 
		'copies', 
		'habilitations'));
    }
	
	// AFFICHE D'UN INTERVENANT VERSION DO
	// chantier/afficherpiece
	// FONCTION APPELEE EN AJAX
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
			echo "Not copied : ".public_path($myPiece->chemin);
		}
		
		return view('intervenant/piece', ['user' => $user, 'piece' => $myPiece, 'key' => md5($key)]);
    }
	
	// AFFICHE DES MANDATS D'UN DOSSIER POUR LE DO
	// chantier/mandats/{id}
    public function mandats($id)
    {
		$user = \Auth::user();
		
		$chantier = Chantier::find($id);
		$page_title = 'Dossier '.$chantier->numero;
		$page_description = $chantier->numero;
		
		$titulaire = Societe::find($chantier->societe);
		$titulaires = Titulaire::where('chantier', $id)->get();
		$evenements = Evenement::where('chantier', $id)->get();
		
        if(!$titulaire)
			return $this->choixpresta($id);
		
		// BOUTONS D'ACTIONS
		$actions = array();
		$actions[] = array("url" => "/chantier/show/".$chantier->id, "label" => "Informations", "style" => "info", "icon" => "<i class='fa fa-info'></i>");
		$actions[] = array("url" => "/chantier/intervenants/".$chantier->id, "label" => "Intervenants", "style" => "info", "icon" => "<i class='fa fa-user-friends'></i>");
		$actions[] = array("url" => "/chantier/vehicules/".$chantier->id, "label" => "Véhicules", "style" => "info", "icon" => "<i class='fa fa-truck'></i>");
		
		// SI ON EST UN ST DE NIV2 ON NE PEUT PAS VOIR CES BOUTONS
		
		$isTitulaire = Titulaire::where('chantier', $id)->where('societe', $user->societeID)->exists();
		if($isTitulaire)
		{
			$actions[] = array("url" => "/chantier/mandats/".$chantier->id, "label" => "Mandats", "style" => "info", "icon" => "<i class='fa fa-sitemap'></i>");
			$actions[] = array("url" => "/chantier/mandater/".$chantier->id, "label" => "Ajouter un prestataire", "style" => "info", "icon" => "<i class='fa fa-plus'></i>");
		}
		elseif($chantier->do == $user->id)
			$actions[] = array("url" => "/chantier/choixpresta/".$chantier->id, "label" => "Titulaires", "style" => "info", "icon" => "<i class='fa fa-plus'></i>");
		
		// BOUTONS DE POPUP
		$popups = array();
		$popups[] = array("target" => "kt_modal_prorogation", "icon" => "<i class='flaticon2-file text-muted'></i>");
		
		// BOUTONS DE NAVIGATION
		$navs = array();
		$navs[] = array("url" => "/chantier/sent", "label" => "Retour", "icon" => "<i class='fa fa-arrow-left'></i>");
		
        return view('chantier/affichage/mandats', compact('page_title', 
		'page_description', 
		'user', 
		'actions', 
		'popups',
		'navs',
		'titulaire', 
		'evenements', 
		'chantier', 
		'titulaires'));
    }
	
	/*** GESTION DES MANDATS ***/
    public function voirmandat(Request $request)
    {
		$user = \Auth::user();
		
		$myItem = Mandat::find($request->input("id"));
		
        return view('chantier/detailmandat', ['user' => $user, 'mandat' => $myItem, 'open' => 'chantier']);
    }
	
    public function mandater($chantierID)
    {
		$user = \Auth::user();
		
		$chantier = Chantier::find($chantierID);
		$page_title = 'Dossier '.$chantier->numero;
		$page_description = $chantier->numero;
		
		$prestataires = Societe::where('deleted', 0)->get();
		$societe = $user->societe;
		
		// BOUTONS D'ACTIONS
		$actions = array();
		$actions[] = array("url" => "/chantier/show/".$chantier->id, "label" => "Informations", "style" => "info", "icon" => "<i class='fa fa-info'></i>");
		$actions[] = array("url" => "/chantier/intervenants/".$chantier->id, "label" => "Intervenants", "style" => "info", "icon" => "<i class='fa fa-user-friends'></i>");
		$actions[] = array("url" => "/chantier/vehicules/".$chantier->id, "label" => "Véhicules", "style" => "info", "icon" => "<i class='fa fa-truck'></i>");
		
		// SI ON EST UN ST DE NIV2 ON NE PEUT PAS VOIR CES BOUTONS
		
		$isTitulaire = Titulaire::where('chantier', $id)->where('societe', $user->societeID)->exists();
		if($isTitulaire)
		{
			$actions[] = array("url" => "/chantier/mandats/".$chantier->id, "label" => "Mandats", "style" => "info", "icon" => "<i class='fa fa-sitemap'></i>");
			$actions[] = array("url" => "/chantier/mandater/".$chantier->id, "label" => "Ajouter un prestataire", "style" => "info", "icon" => "<i class='fa fa-plus'></i>");
		}
		elseif($chantier->do == $user->id)
			$actions[] = array("url" => "/chantier/choixpresta/".$chantier->id, "label" => "Titulaires", "style" => "info", "icon" => "<i class='fa fa-plus'></i>");
		
		// BOUTONS DE POPUP
		$popups = array();
		$popups[] = array("target" => "kt_modal_prorogation", "icon" => "<i class='flaticon2-file text-muted'></i>");
		
		// BOUTONS DE NAVIGATION
		$navs = array();
		$navs[] = array("url" => "/chantier/sent", "label" => "Retour", "icon" => "<i class='fa fa-arrow-left'></i>");
		
        return view('chantier/affichage/mandater', compact('page_title', 
		'page_description', 
		'user', 
		'actions', 
		'popups',
		'navs',
		'prestataires', 
		'societe', 
		'chantier'));
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
	
	public function rechercherpresta(Request $request)
    {
		$user = \Auth::user();
		
		$prestataires = Societe::where('id', '<>', $user->societeID)->where('raisonSociale', 'like', '%'.$request->input("keywords").'%')->get();
		
		return view('chantier/liste-presta', ['user' => $user, 'prestataires' => $prestataires, 'open' => 'chantier']);
    }
	
	public function liste_titulaires(Request $request)
    {
		$user = \Auth::user();
		
		$myItem = Chantier::find($request->input("id"));
		$titulaires = Titulaire::where('chantier', $request->input("id"))->get();
		
		return view('chantier/liste-titu', ['user' => $user, 'titulaires' => $titulaires, 'chantier' => $myItem, 'open' => 'chantier']);
    }
	
    public function showDo($id, $message = "EMPTY")
    {
		$user = \Auth::user();
		
		$myItem = ChantierDo::find($id);
		
        return view('chantier/changedo', ['user' => $user, 'chantier' => $myItem, 'message' => $message, 'open' => 'chantier']);
    }
	
	
	/*** GESTION DE LA VIE DU CHANTIER ***/
    public function save(Request $request)
    {
		$user = \Auth::user();
		
        $this->validate($request, ['numero' => 'required']);

		if(Chantier::where('numero', $request->input("numero"))->where('do', $user->societeID)->doesntExist() && $request->input("date_debut") <= $request->input("date_fin"))
		{
	        if($request->input("typeChantier") == 0 || $user->do == 0)
			{
				// ON EST DANS UN DOSSIER CREE PAR UN PRESTA
				$myItem = new Chantier;
		        $myItem->numero = $request->input("numero");
		        $myItem->initiateur = $user->id;
		        $myItem->libelle = $request->input("libelle");
		        $myItem->date_debut = $request->input("date_debut");
		        $myItem->date_fin = $request->input("date_fin");
		        $myItem->do = $user->societeID;
		        $myItem->type_chantier = 0;

				// ON FIGE LES INFOS DE VALIDATION AU MOMENT DE LA CREATION DU DOSSIER
				$typeChantier = DoChantier::find($request->input("typeChantier"));

				$myItem->mecanisme = 1;
				$myItem->duree_validation = 0;

		        $myItem->save();
				
				// ON AJOUTE LE PRESTA COMME TITULAIRE
		        $myTitulaire = new Titulaire;
		        $myTitulaire->chantier = $myItem->id;
		        $myTitulaire->societe = $user->societeID;
 
		        $myTitulaire->save();

				return $this->show($myItem->id);
			}
			else
			{
				$myItem = new Chantier;
		        $myItem->numero = $request->input("numero");
		        $myItem->initiateur = $user->id;
		        $myItem->libelle = $request->input("libelle");
		        $myItem->date_debut = $request->input("date_debut");
		        $myItem->date_fin = $request->input("date_fin");
		        $myItem->do = $user->societeID;
		        $myItem->type_chantier = $request->input("typeChantier");

				// ON FIGE LES INFOS DE VALIDATION AU MOMENT DE LA CREATION DU DOSSIER
				$typeChantier = DoChantier::find($request->input("typeChantier"));

				$myItem->mecanisme = $typeChantier->mecanisme_validation;
				$myItem->validation_niv1 = $typeChantier->profil_1;
				$myItem->validation_niv2 = $typeChantier->profil_2;
				$myItem->validation_niv3 = $typeChantier->profil_3;
				$myItem->duree_validation = $typeChantier->duree_validation;

		        $myItem->save();

				return $this->show($myItem->id);
			}
		}
		else
		{
			$infos = array();
			$infos["numero"] = $request->input("numero");
			$infos["libelle"] = $request->input("libelle");
			$infos["date_debut"] = $request->input("date_debut");
			$infos["date_fin"] = $request->input("date_fin");
			
			return ($request->input("date_debut") > $request->input("date_fin")) ? $this->create($infos, "DATE_ERROR") : $this->create($infos, "ITEM_EXISTS");
		}
    }
	
    public function savevirtuel(Request $request)
    {
		$user = \Auth::user();
		
        $this->validate($request, ['numero' => 'required']);

		if(Chantier::where('numero', $request->input("numero"))->where('do', $user->societeID)->doesntExist())
		{
	        $myItem = new Chantier;
	        $myItem->numero = $request->input("numero");
	        $myItem->initiateur = $user->id;
	        $myItem->categorie = 'virtuel';
	        $myItem->date_debut = date("Y-m-d");
	        $myItem->date_fin = date("Y-m-d");
	        $myItem->do = $user->societeID;
	        $myItem->type_chantier = 0;
	        
			if($request->input("mandataireID") == 0)
			{
				$societe = new Societe;
				$societe->raisonSociale = $request->input("raisonSociale");
				$societe->noSiret = $request->input("noSiret");
				$societe->email = $request->input("emailDirigeant");
				$societe->autre_email = $request->input("autreEmail");

				$societe->save();
				
				$user = new User;
				$user->nom = "";
				$user->prenom = "";
				$user->email = $request->input("emailDirigeant");
				$user->name = "";
				$user->do = 0;
				$user->groupe = "user";
				$user->societeID = $societe->id;
				$mypass = "Password*";
		        $user->password = Hash::make($mypass);
		        $user->fonction = $mypass;
				$user->save();
			}
			else
			{
				$societe = Societe::find($request->input("mandataireID"));
			}

	        $myItem->societe = $societe->id;
	        $myItem->save();

			return $this->listeglobale();
		}
		else
		{
			$infos = array();
			$infos["numero"] = $request->input("numero");
			
			return $this->createv($infos, "Numéro de dossier existant");
		}
    }
	
	/*** GESTION DE LA VIE DU CHANTIER ***/
    public function savepresta(Request $request)
    {
		$myUser = \Auth::user();
		
        $this->validate($request, ['numero' => 'required']);

		if(Chantier::where('numero', $request->input("numero"))->where('societe', $myUser->societeID)->doesntExist() && $request->input("date_debut") <= $request->input("date_fin"))
		{
	        if($request->input("typeChantier") == 0 || $user->do == 0)
			{
				// ON EST DANS UN DOSSIER CREE PAR UN PRESTA
				$myItem = new Chantier;
		        $myItem->numero = $request->input("numero");
		        $myItem->initiateur = $myUser->id;
		        $myItem->libelle = $request->input("libelle");
		        $myItem->date_debut = $request->input("date_debut");
		        $myItem->date_fin = $request->input("date_fin");
		        
				// ON CREE UN DO AVEC LE MINIMUM D'INFOS
				$societe = new Societe;
				$societe->raisonSociale = $request->input("raison_sociale");
				$societe->email = $request->input("email");
				$societe->save();
				
				// ON CREE UN COMPTE UTILISATEUR POUR CE DO
				$user = new User;
				$user->nom = $request->input("nom");
				$user->prenom = $request->input("prenom");
				$user->email = $request->input("email");
				$user->name = $request->input("nom")." ".$request->input("prenom");
				$user->do = 1;
				$user->groupe = "user";
				$user->societeID = $societe->id;
				$mypass = str_random(8);
		        $user->password = Hash::make($mypass);
		        $user->fonction = $mypass;
				$user->save();
				
				$myItem->societe = $myUser->societeID;
				$myItem->do = $societe->id;
		        $myItem->type_chantier = 0;
				$myItem->mecanisme = 1;
				$myItem->duree_validation = 12;
				$myItem->save();
				
				// ON AJOUTE LE PRESTA COMME TITULAIRE
		        $myTitulaire = new Titulaire;
		        $myTitulaire->chantier = $myItem->id;
		        $myTitulaire->societe = $myUser->societeID;
		        $myTitulaire->save();

				return $this->show($myItem->id);
			}
		}
		else
		{
			$infos = array();
			$infos["numero"] = $request->input("numero");
			$infos["libelle"] = $request->input("libelle");
			$infos["date_debut"] = $request->input("date_debut");
			$infos["date_fin"] = $request->input("date_fin");
			
			return ($request->input("date_debut") > $request->input("date_fin")) ? $this->create($infos, "DATE_ERROR") : $this->create($infos, "ITEM_EXISTS");
		}
    }
	
    public function delete(Request $request)
    {
		$user = \Auth::user();
		
		$myItem = Chantier::find($request->id);
		$myItem->deleted = date("Y-m-d");
		$myItem->save();
		
		$this->sent();
    }
	
    public function savememo(Request $request)
    {
		$user = \Auth::user();
		
		$myItem = Chantier::find($request->id);
		$myItem->memo = $request->input("memo");
		$myItem->save();
    }
	
    public function restore($id)
    {
		$user = \Auth::user();
		
		$myItem = Chantier::find($id);
		$myItem->deleted = NULL;
		$myItem->save();
		
        return $this->sent();
    }
	
	
	
    public function validation($id, $message = "EMPTY")
    {
		$user = \Auth::user();
		
		$myItem = ChantierDo::find($id);
		$profils = Profil::whereIn('societe', [$user->societeID, $myItem->do_deux])->where('validation_entites', 1)->get();
		
        return view('chantier/validation', ['user' => $user, 'profils' => $profils, 'chantier' => $myItem, 'message' => $message, 'open' => 'chantier']);
    } 
	
    public function sendUrl(Request $request)
    {
		$user = \Auth::user();
		
		$intervenant = EquipierDo::find($request->input("id"));
		$res = Mail::to('jgd@cgpisoft.fr')->send(new ChantierDoUrl($intervenant));
    } 
	
	public function savevalidation(Request $request)
    {
		$user = \Auth::user();
		
		$myItem = ChantierDo::find($request->input("chantier"));
		$myItem->validation_entites = ($request->input("validation_entites") == "on") ? 1 : 0;
		$myItem->validation_pieces = ($request->input("validation_pieces") == "on") ? 1 : 0;
		$myItem->save();
		
        return $this->validation($myItem->id);
    }
	
    public function proroger(Request $request)
    {
		$user = \Auth::user();
		
		$myItem = Chantier::find($request->input("chantierID"));
		if($request->input("date_fin") > date("Y-m-d") && $request->input("date_fin") > $myItem->date_fin)
		{
			$myItem->date_fin = $request->input("date_fin");
			$myItem->save();
			
			// PROLONGATION DES DAV
			// ON GERE LA MISE EN RENOUVELLMENT DES FIDAAS
			// ON ENVOIE UNE NOTIFICATION A L'ACCUEIL POUR INDIQUER LE CHANGEMENT DE DATE
			$myItem->notifierChangementDate();
			
			$this->show($request->input("chantierID"), "PROROGATION_OK");
		}	
		else
		{
			abort(403);
		}
    }
	
    public function cloturer(Request $request)
    {
		$user = \Auth::user();
		
		$myItem = Chantier::find($request->id);
		$myItem->delete();
			
		return "Chantier supprimé";
    }
	
	/*** GESTION DES TITULAIRES D'UN CHANTIER ***/
	public function addpresta(Request $request)
    {
		$user = \Auth::user();
		
		$myItem = Chantier::find($request->input("chantierID"));
		
		// SI LA SOCIETE EST A 0 ON VA LA CREER
		if($request->input("mandataireID") == 0)
		{
			$societe = new Societe;
			$societe->raisonSociale = $request->input("raisonSociale");
			$societe->noSiret = $request->input("noSiret");
			$societe->email = $request->input("emailDirigeant");
			$societe->autre_email = $request->input("autreEmail");
			$societe->temporaire = $request->input("interim");
			
			$societe->save();
		}
		else
		{
			$societe = Societe::find($request->input("mandataireID"));
		}
			
		// SI C'EST LE TITULAIRE PRINCIPAL DE LA COMMANDE ON LE MET DANS LE DOSSIER SINON ON LE RAJOUTE DANS LE MANDAT
		if($request->input("titulaire"))
		{
			$myItem->societe = $societe->id;
			$myItem->save();
			
	        try
			{
		        $myTitulaire = new Titulaire;
		        $myTitulaire->chantier = $request->input("chantierID");
		        $myTitulaire->societe = $societe->id;
 
		        $myTitulaire->save();
			} catch (\Exception $e) {
				return view('message/notify', ['type' => 'danger', 'icon' => 'fa-exclamation-triangle', 'message' => 'Ce prestataire est déjà affecté à ce dossier']);
			}
		}
		else
		{
	        try
			{
		        $myTitulaire = new Titulaire;
		        $myTitulaire->chantier = $request->input("chantierID");
		        $myTitulaire->societe = $societe->id;
 
		        $myTitulaire->save();
			} catch (\Exception $e) {
				return view('message/notify', ['type' => 'danger', 'icon' => 'fa-warning', 'message' => 'Ce prestataire est déjà affecté à ce dossier']);
			}
		}
		
		// ON NOTIFIE LE PRESTA PAR MAIL
		if($request->input("mandataireID") == 0)
			$res = Mail::to($request->input("emailDirigeant"))->send(new NewChantier2($myItem, $societe));
		else
			$res = Mail::to($request->input("emailDirigeant"))->send(new NewChantier($myItem));
				
		$titulaires = Titulaire::where('chantier', $request->input("chantierID"))->get();
		$prestataires = Societe::where('id', '<>', $user->societeID)->get();
		
		return view('message/notify', ['type' => 'success', 'icon' => 'fa-check', 'message' => 'Prestataire ajouté']);
	}
	
	public function supprimerpresta(Request $request)
	{
		$user = \Auth::user();
	
		$myItem = Titulaire::find($request->input("id"));
		$myChantier = Chantier::find($myItem->chantier);
		$myItem->delete();
		
		$titulaires = Titulaire::where('chantier', $myChantier->id)->get();
		$prestataires = Societe::where('deleted', 0)->get();
		
		return view('chantier/liste-titu', ['user' => $user, 'chantier' => $myChantier, 'titulaires' => $titulaires, 'open' => 'chantier']);
	}
	
	public function supprimertitulaireprincipal(Request $request)
	{
		$user = \Auth::user();
	
		$myChantier = Chantier::find($request->input("id"));
		$myChantier->societe = NULL;
		$myChantier->save();
			
		$titulaires = Titulaire::where('chantier', $request->input("chantierID"))->get();
		$prestataires = Societe::where('deleted', 0)->get();
		
		return view('chantier/liste-titu', ['user' => $user, 'chantier' => $myChantier, 'titulaires' => $titulaires, 'open' => 'chantier']);
	}
		
	public function choixpresta($id)
	{
		$user = \Auth::user();
		
		$myItem = Chantier::find($id);
		$mandataires = array();
		
		$titulaires = Titulaire::where('chantier', $id)->get();
		$prestataires = Societe::where('deleted', 0)->get();
		
		return view('chantier/choixpresta', ['user' => $user, 'prestataires' => $prestataires, 'chantier' => $myItem, 'titulaires' => $titulaires, 'open' => 'chantier']);
	}
	
    /*** GESTION DES INTERVENANTS DU CHANTIER ***/
    public function listeglobale($filter = 'pending')
    {
		$user = \Auth::user();
		$societe = Societe::find($user->societeID);
		
		$autorisations = Autorisation::where('do', $user->societeID)->get();
		
		if($filter == 'pending')
		{
			$autorisations = Autorisation::where('do', $user->societeID)->where('statut', 'pending')->get();
		}	
		elseif($filter == 'renew')
		{
			$autorisations = Autorisation::where('do', $user->societeID)->where('statut', 'renew')->get();
		}
		else
		{
			$autorisations = Autorisation::where('do', $user->societeID)->get();
		}	
		
		$pieces = json_decode($societe->pieces_validation, true);
		
        return view('chantier/listeglobale', ['user' => $user, 'autorisations' => $autorisations, 'pieces' => $pieces, 'open' => 'autorisations']);
    }
	
    public function voirautorisation($id, $message = "")
    {
		$user = \Auth::user();
		$societe = Societe::find($user->societeID);
		
		$autorisation = Autorisation::find($id);
		$entiteID = $autorisation->entite;
		$entite = Entite::find($autorisation->entite);
		$prestataire = Societe::find($entite->societe);
		$chantiers = DB::table('chantiers')
			->where('do', $user->societeID)
			->whereIn('id', function($query) use ($entiteID)
			    {
			        $query->select(DB::raw('chantier'))
			              ->from('equipiers')
			              ->whereRaw('intervenant = '.$entiteID);
			    })
            ->get('chantiers.numero');
		
		$typesPieces = array();
		$oblig4 = ($societe->pieces_intervenants == "") ? array() : json_decode($societe->pieces_intervenants, true);
		foreach($oblig4 as $piece)
		{
			$typePiece = TypePiece::find($piece);
			$typesPieces[] = $typePiece;
		}
		
		$oblig5 = ($societe->pieces_validation == "") ? array() : json_decode($societe->pieces_validation, true);
		
        return view('chantier/autorisation', ['user' => $user, 'entite' => $entite, 'societe' => $societe, 'oblig4' => $typesPieces, 'oblig5' => $oblig5, 'prestataire' => $prestataire, 'chantiers' => $chantiers, 'autorisation' => $autorisation, 'open' => 'autorisations', 'message' => $message]);
    }
	
    public function saveautorisation(Request $request)
    {
		$user = \Auth::user();
		
		$autorisation = Autorisation::find($request->id);
		$autorisation->informations = $request->input("memo");
		$autorisation->save();
    }
	
    public function annulerAutorisation(Request $request)
    {
		$autorisation = Autorisation::find($request->input("autorisation"));
		$autorisation->commentaire = $autorisation->commentaire."<br>".$request->input("commentaire");
		$autorisation->date_fin_invalidite = $request->input("date_fin_invalidite");
		$autorisation->date_fin = NULL;
		$autorisation->statut = "rejected";
		$autorisation->save();
		
		return $this->voirautorisation($request->input("autorisation"));
	}
	
    public function changerAutorisation(Request $request)
    {
		$user = \Auth::user();
		
		$autorisation = Autorisation::find($request->input("autorisation"));

		$autorisation->commentaire = $autorisation->commentaire."<br>".$request->input("commentaire");
		$autorisation->statut = "authorized";
		$autorisation->date_fin = $request->input("date_fin_validite");
		$autorisation->date_fin_invalidite = NULL;
		$message = "ENTITE_AUTHORIZED";
		
		$autorisation->save();
		
		return $this->voirautorisation($request->input("autorisation"));
    }
	
    public function saveattributs(Request $request)
    {
		$user = \Auth::user();
		
		$autorisation = Autorisation::find($request->id);
		if($request->input("enquete_administrative"))
			$autorisation->enquete_administrative = $request->input("enquete_administrative");
		else
			$autorisation->enquete_administrative = 0;
	
		if($request->input("enquete_interne"))
			$autorisation->enquete_interne = $request->input("enquete_interne");
		else
			$autorisation->enquete_interne = 0;
		
		if($request->input("avis_interne"))
			$autorisation->avis_interne = $request->input("avis_interne");
		else
			$autorisation->avis_interne = 0;
			
		$autorisation->date_ea = ($request->input("date_ea")) ? $request->input("date_ea") : NULL;
		$autorisation->date_ei = ($request->input("date_ei")) ? $request->input("date_ei") : NULL;
		$autorisation->date_ai = ($request->input("date_ai")) ? $request->input("date_ai") : NULL;
		$autorisation->save();
		
		return $this->voirautorisation($request->id);
    }
	
    public function personnelautorise()
    {
		$entites = Entite::all();
		
		$res = array();
		foreach($entites as $entite)
		{
			$res[] = $entite->name;
		}
		
		return response()->json($res);
    }
	
    public function personnelexclus()
    {
		$entites = Entite::all();
		
		$res = array();
		foreach($entites as $entite)
		{
			$res[] = $entite->name;
		}
		
		return response()->json($res);
    }
	
    
	
    public function archive($id)
    {
		$user = \Auth::user();
		
		$myItem = Equipier::find($id);
		$entite = Entite::find($myItem->intervenant);
		$copies = Piece::where('entite', $entite->id)->where('do', $user->societeID)->get();
		$habilitations = EntiteHabilitation::where('entite', $id)->get();
		
		$zip_file = 'Archive_Pieces_'.$entite->nom.'.zip';
		
		$zip = new \ZipArchive();
		$zip->open($zip_file, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);
		
		// ON ENVOIE LES PIECES DO
		foreach($copies as $copie)
		{
			$typePiece = TypePiece::find($copie->type_piece);
			if($typePiece)
				$zip->addFile($copie->chemin, $typePiece->abbreviation.".".$copie->extension);
		}
		
		// ON ENVOIE LES PIECES CHANTIER
		$copies = Piece::where('entite', $entite->id)->where('chantier', $myItem->chantier)->get();
		foreach($copies as $copie)
		{
			$typePiece = TypePiece::find($copie->type_piece);
			if($typePiece)
				$zip->addFile($copie->chemin, $typePiece->abbreviation.".".$copie->extension);
		}
		
		$zip->close();

		// We return the file immediately after download
		return response()->download($zip_file);
    }
	
    
	
    public function choixrdv($id)
    {
		$user = \Auth::user();
		
		$myItem = Equipier::find($id);
		$entite = Entite::find($myItem->intervenant);
		$chantier = Chantier::find($myItem->chantier);
		$chantiers = Equipier::where('intervenant', $entite->id)->get();
		
        return view('chantier/intervenant', ['user' => $user, 'entite' => $entite, 'intervenant' => $myItem, 'chantier' => $chantier, 'pieces' => array(), 'chantiers' => $chantiers, 'open' => 'chantier']);
    }
	
    public function upload(Request $request)
    {
		$user = \Auth::user();
        Storage::put("temp/".$request->input("data"), $request->file("file"));
    }
	
    public function gerervirtuel($id)
    {
		$user = \Auth::user();
		$societe = Societe::find($user->societeID);
	
		$societeID = $user->societeID;
	
		$categorie = "intervenant";
		if($societe->temporaire)
			$categorie = "interim";
	
		$myItem = Chantier::find($id);
		$chantierID = $id;
	
		if($myItem->do == $user->societeID)
		{
			$titulaire = Societe::find($myItem->societe);
			$remplacants = array();

			$equipe = Equipier::where('chantier', $chantierID)->whereIn('categorie', ['intervenant', 'interim', 'etranger'])->get();
		}
		else
		{
			$titulaire = Societe::find($user->societeID);
			$remplacants = DB::table('entites')
				->where('societe', $user->societeID)
				->whereIn('categorie', ['intervenant', 'interim', 'etranger'])
				->whereNotIn('id', function($query) use ($chantierID)
				    {
				        $query->select(DB::raw('intervenant'))
				              ->from('equipiers')
				              ->whereRaw('equipiers.chantier = '.$chantierID);
				    })
	            ->get('entites.*');

			$equipe = Equipier::where('chantier', $chantierID)->where('societe', $user->societeID)->whereIn('categorie', ['intervenant', 'interim', 'etranger'])->get();
		}
	
        return view('chantier/intervenantsvirtuel', ['user' => $user, 'equipe' => $equipe, 'remplacants' => $remplacants, 'titulaire' => $titulaire, 'chantier' => $myItem, 'open' => 'chantier', 'categorie' => $categorie]);
    }
	
    
	
    public function intervenantsDo($id)
    {
		$user = \Auth::user();
		
		$societeID = $user->societeID;
		
		$myItem = ChantierDo::find($id);
		$chantierID = $id;
		
		$equipe = EquipierDo::where('chantier', $chantierID)->get();
			
		return view('chantier/intervenantsDo', ['user' => $user, 'equipe' => $equipe, 'chantier' => $myItem, 'open' => 'chantier']);
    }

	public function chargerdocument(Request $request)
	{
		$user = \Auth::user();
		
		$copie = new CopiesDo();
		$copie->type_piece = $request->input("type_piece");
		$copie->entite = $request->input("entite");
		$copie->equipier = $request->input("id");
		$copie->chantier = $request->input("chantier");
		
		$entite = Entite::find($request->input("entite"));
		
		if ($request->hasFile('document'))
		{
			$name = $request->document->getClientOriginalName();
			$error = $request->document->move("pieces/".$entite->societe."/".$entite->id."/pieces/".$name);
			$copie->chemin = "pieces/".$entite->societe."/".$entite->id."/pieces/".$name;
			$copie->extension = $request->document->getClientOriginalExtension();
			$copie->save();
			
			return $this->voirmateriel($request->input("id"));
		}
		else
		{
			
		}
	}
	
	public function demarrer(Request $request)
    {
		$user = \Auth::user();
	
		$myItem = ChantierDo::find($request->input("id"));
		$myItem->statut = "en cours";
		$myItem->save();
			
		$premiereAction = Action::where('chantier', $request->input("id"))->first();
		$premiereAction->statut = "en cours";
		$premiereAction->save();
    }
	
	public function terminer(Request $request)
    {
		$user = \Auth::user();
	
		$premiereAction = Action::find($request->input("id"));
		$premiereAction->statut = "termine";
		$premiereAction->save();
		
		$nextAction = Action::where('chantier', $premiereAction->chantier)->where('ordre', '>', $premiereAction->ordre)->first();
		if($nextAction)
		{
			$nextAction->statut = "en cours";
			$nextAction->save();
		}	
		
		echo '<i class="fa fa-check-circle"></i> Action terminée';
    }
	
	public function action($id)
    {
		$user = \Auth::user();
		
		$action = Action::find($id);
		$myItem = ChantierDo::find($action->chantier);
		$intervenants = EquipierDo::where('chantier', $action->chantier)->get();
		$documents = Justificatif::where('action', $id)->get();
	
        return view('chantier/action', ['user' => $user, 'documents' => $documents, 'intervenants' => $intervenants, 'action' => $action, 'chantier' => $myItem, 'open' => 'chantier']);
    }
	
	public function chargerjustificatif(Request $request)
    {
		if ($request->hasFile('justificatif'))
		{
			$action = Action::find($request->input("action"));
			
			$name = $request->justificatif->getClientOriginalName();
			$error = $request->justificatif->move("maitenance/".$action->chantier."/".$name);
			
			$myPiece = new Justificatif();
			$myPiece->action = $request->input("action");
			$myPiece->libelle = ($request->input("libelle") == "") ? $name : $request->input("libelle");
			$myPiece->chemin = "maitenance/".$action->chantier."/".$name;
			$myPiece->extension = $request->justificatif->getClientOriginalExtension();
			$myPiece->save();
			
			return $this->action($request->input("action"));
		}
		else
		{
			// DO NOTHING FOR NOW
			return $this->showEntite($entite->id, "ERROR_MISSING");
		}
	}
	
	public function deleteaction(Request $request)
    {
		$action = Action::find($request->input("id"));
		$action->delete();
	}
	
	public function deletefile(Request $request)
    {
		$justificatif = Justificatif::find($request->input("id"));
		$justificatif->delete();
	}
	
	public function saveaction(Request $request)
    {
		$action = Action::find($request->input("action"));
		$action->description = $request->input("description");
		$action->save();
		
		return $this->action($request->input("action"));
	}
	
	public function actionsDo($id)
    {
		$user = \Auth::user();
		
		$myItem = ChantierDo::find($id);
		$actions = Action::where('chantier', $id)->get();
		$intervenants = EquipierDo::where('chantier', $id)->get();
	
        return view('chantier/actionsDo', ['user' => $user, 'intervenants' => $intervenants, 'actions' => $actions, 'chantier' => $myItem, 'open' => 'chantier']);
    }
	
	public function addnewaction(Request $request)
	{
		$user = \Auth::user();
	
		$myItem = new Action;
        $myItem->libelle = $request->input("libelle");
        $myItem->ordre = $request->input("ordre");
        $myItem->mode = $request->input("mode");
        $myItem->date_limite = $request->input("date_limite");
        $myItem->chantier = $request->input("chantier");
        $myItem->qui = $request->input("intervenant");
        $myItem->validation = ($request->input("need_validation") == 'on') ? $request->input("validation") : 0;
		$myItem->save();

		$actions = Action::where('chantier', $request->input("chantier"))->get();
		return view('chantier/ListeActionsDo', ['user' => $user, 'actions' => $actions]);
	}
		
	public function addnewintervenantdo(Request $request)
	{
		$user = \Auth::user();
		
		$myItem = new EquipierDo;
        $myItem->nom = $request->input("nom");
        $myItem->prenom = $request->input("prenom");
        $myItem->societe = $request->input("societe");
        $myItem->fonction = $request->input("fonction");
        $myItem->email = $request->input("email");
        $myItem->telephone = $request->input("telephone");
        $myItem->chantier = $request->input("chantier");
        $myItem->statut = "invite";
		$myItem->save();
		
		$id = $request->input("chantier");
				
		return $this->intervenantsDo($id);
	}
			
	public function ajouterintervenantdo(Request $request)
	{
		$user = \Auth::user();
		
        $myTeammate = new EquipierDo;
        $myTeammate->intervenant = $request->input("intervenant");
        $myTeammate->chantier = $request->input("chantier");
        $myTeammate->societe = $user->societeID;
		$myTeammate->save();
		
		return $this->intervenantsDo($myTeammate->chantier);
	}
	
	public function voirmateriel($id)
	{
		$user = \Auth::user();
		
		$myTeammate = EquipierDo::find($id);
		$entite = Entite::find($myTeammate->intervenant);
		$chantier = ChantierDo::find($myTeammate->chantier);
		
		$typeEntite = TypeEntite::find($entite->type_entite);
		$typesPieces = TypePiece::where ('type_entite', $entite->type_entite)->get();
		$lesChamps = json_decode($typeEntite->champs);
		$copies = array();
		
		return view('chantier.intervenant_do', ['user' => $user, 'materiel' => $myTeammate, 'entite' => $entite, 'chantier' => $chantier, 'copies' => $copies, 'lesChamps' => $lesChamps, 'typesPieces' => $typesPieces]);
	}
		
	public function validerintervenant(Request $request)
	{
		$user = \Auth::user();
		
		// GESTION DE LA DOUBLE VALIDATION
		$myTeammate = Equipier::find($request->input("id"));
		$chantier = Chantier::find($myTeammate->chantier);
		$typeChantier = TypeChantier::find($chantier->type_chantier);
		$intervenant = $myTeammate;
		
		switch($chantier->mecanisme)
		{
			// DANS UN CAS 1 OU 2 ON NE FAIT RIEN ET L'INTERVENANT EST VALIDE
			case 1 :
			case 2 :
				// PAS POSSIBLE
				break;
			case 3 :
			case 4 :
				// ON REGARDE LE NIVEAU DE VALIDATION NECESSAIRE
				if($typeChantier->niveau_validation == 1 && $request->input("niveau") == 1)
				{
					// ON VALIDE L'INTERVENANT
					$myTeammate->validation = date("Y-m-d H:i:s");
					$myTeammate->validation1 = date("Y-m-d H:i:s");
					$myTeammate->auteur_validation = $user->id;
					$myTeammate->auteur_validation1 = $user->id;
					$myTeammate->notifie = 1;
					$myTeammate->save();
				}
				else
				{
					if($typeChantier->niveau_validation == 2)
					{
						// SI C'EST LA PREMIERE VALIDATION ALORS ON APPELLE LE NIVEAU 2
						if(!$myTeammate->validation1 && $request->input("niveau") == 1)
						{
							$myTeammate->validation1 = date("Y-m-d H:i:s");
							$myTeammate->auteur_validation1 = $user->id;
							$myTeammate->save();
							
							// NOTIFICATION DU DO
							$notification = new Notification();
							$notification->chantier = $myTeammate->chantier;
							$notification->entite = $myTeammate->intervenant;
							$notification->prestataire = $chantier->do;
							$notification->message = $chantier->numero." // ".$intervenant->name()." en attente de validation";
							$notification->save();
							
							$profil = Profil::find($typeChantier->profil_2);
							if($profil)
								$profil->notifier($this->id, "APPEL_VALIDATION");
						}
						else
						{
							$myTeammate->validation = date("Y-m-d H:i:s");
							$myTeammate->validation2 = date("Y-m-d H:i:s");
							$myTeammate->auteur_validation = $user->id;
							$myTeammate->auteur_validation2 = $user->id;
							$myTeammate->save();
							
							// NOTIFICATION DU PRESTATAIRE
							$notification = new Notification();
							$notification->chantier = $myTeammate->chantier;
							$notification->entite = $myTeammate->intervenant;
							$notification->prestataire = $myTeammate->societe;;
							$notification->message = $chantier->numero." // ".$intervenant->name()." validé";
							$notification->save();
						}
					}
					
					if($typeChantier->niveau_validation == 3)
					{
						// SI C'EST LA PREMIERE VALIDATION ALORS ON APPELLE LAE NIVEAU 2
						if(!$myTeammate->validation1 && $request->input("niveau") == 1)
						{
							$myTeammate->validation1 = date("Y-m-d H:i:s");
							$myTeammate->auteur_validation1 = $user->id;
							$myTeammate->save();
							
							// NOTIFICATION DU DO
							$notification = new Notification();
							$notification->chantier = $myTeammate->chantier;
							$notification->entite = $myTeammate->intervenant;
							$notification->prestataire = $chantier->do;
							$notification->message = $chantier->numero." // ".$intervenant->name()." en attente de validation";
							$notification->save();
							
							$profil = Profil::find($typeChantier->profil_2);
							if($profil)
								$profil->notifier($this->id, "APPEL_VALIDATION");
						}
						elseif(!$myTeammate->validation2 && $request->input("niveau") == 2)
						{
							$myTeammate->validation = date("Y-m-d H:i:s");
							$myTeammate->validation2 = date("Y-m-d H:i:s");
							$myTeammate->auteur_validation = $user->id;
							$myTeammate->auteur_validation2 = $user->id;
							$myTeammate->save();
								
							// NOTIFICATION DU DO
							$notification = new Notification();
							$notification->chantier = $myTeammate->chantier;
							$notification->entite = $myTeammate->intervenant;
							$notification->prestataire = $chantier->do;
							$notification->message = $chantier->numero." // ".$intervenant->name()." en attente de validation";
							$notification->save();
							
							$profil = Profil::find($typeChantier->profil_3);
							if($profil)
								$profil->notifier($this->id, "APPEL_VALIDATION");
						}
						else
						{
							$myTeammate->validation = date("Y-m-d H:i:s");
							$myTeammate->validation3 = date("Y-m-d H:i:s");
							$myTeammate->auteur_validation = $user->id;
							$myTeammate->auteur_validation3 = $user->id;
							$myTeammate->save();
							
							// NOTIFICATION DU PRESTATAIRE
							$notification = new Notification();
							$notification->chantier = $myTeammate->chantier;
							$notification->entite = $myTeammate->intervenant;
							$notification->prestataire = $myTeammate->societe;;
							$notification->message = $chantier->numero." // ".$intervenant->name()." validé";
							$notification->save();
						}
					}
				}
				break;
		} 
		
		return view('chantier.validationintervenant', ['user' => $user, 'intervenant' => $intervenant, 'chantier' => $chantier]);
	}
	
	public function invaliderintervenant(Request $request)
	{
		$user = \Auth::user();
		
		$myTeammate = Equipier::find($request->input("id"));
		$myTeammate->validation = date('Y-m-d H:i:s');
		$myTeammate->auteur_validation = $user->id;
		$myTeammate->cle = NULL;
		$myTeammate->save();
		
		$chantier = Chantier::find($myTeammate->chantier);
		$intervenant = $myTeammate;
		
		return view('chantier.validationintervenant', ['user' => $user, 'intervenant' => $intervenant, 'chantier' => $chantier]);
	}
	
    public function download_fic($id)
    {
		$user = \Auth::user();
		
		$equipier = Equipier::find($id);
		$chantier = Chantier::find($equipier->chantier);
		$entite = Entite::find($equipier->intervenant);
		$employeur = Societe::find($entite->societe);
		$do = Societe::find($chantier->do);
		
		$pdf = PDF::loadView('documents/fic', ['user' => $user, 'equipier' => $equipier, 'entite' => $entite, 'chantier' => $chantier, 'do' => $do, 'employeur' => $employeur]);
		return $pdf->download('fidaa.pdf');
	}
	
    public function download_fi($id)
    {
		$user = \Auth::user();
		
		$equipier = Equipier::find($id);
		
		$pdf = PDF::loadView('documents/fi', ['user' => $user, 'equipier' => $equipier]);
		return $pdf->download('fi.pdf');
	}
	
    public function download_fei($id)
    {
		$user = \Auth::user();
		
		$equipier = Equipier::find($id);
		
		$pdf = PDF::loadView('documents/fei', ['user' => $user, 'equipier' => $equipier]);
		return $pdf->download('fei.pdf');
	}
	
    public function download_dav($id)
    {
		$user = \Auth::user();
		
		$equipier = Equipier::find($id);
		
		$pdf = PDF::loadView('documents/dav', ['user' => $user, 'equipier' => $equipier]);
		return $pdf->download('dav.pdf');
	}
	
    public function download_fil($id)
    {
		$user = \Auth::user();
		
		$equipier = Equipier::find($id);
		
		$pdf = PDF::loadView('documents/fil', ['user' => $user, 'equipier' => $equipier]);
		return $pdf->download('fil.pdf');
	}
	
    public function ajouterequipier(Request $request)
    {
		$user = \Auth::user();
		
		$chantierID = $request->input("id");
		$chantier = Chantier::find($request->input("id"));
		$myEntity = Entite::find($request->input("entiteID"));
		
        $myTeammate = new Equipier;
        $myTeammate->intervenant = $request->input("entiteID");
        $myTeammate->chantier = $request->input("id");
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
			
	        $equipe = Equipier::where('chantier', $chantierID)->where('societe', $user->societeID)->where('categorie', 'vehicule')->get();
		}
		else
		{
			$societe = Societe::find($user->societeID);
			if($societe->temporaire)
				$myTeammate->categorie = "interim";
			else
				$myTeammate->categorie = $myEntity->nature;
				
			// ON RECUPERE LE TYPE DE PIECES NECESSAIRE POUR LE DOSSIER
			$myTeammate->save();
			
			// ON VA RECUPERER LES PIECE ET LES METTRE CHEZ LE DO
			$myEntity->chargerPieces($chantier->id);

			$equipe = Equipier::where('chantier', $chantierID)->where('societe', $user->societeID)->where('categorie', 'intervenant')->get();
			$equipe_int = Equipier::where('chantier', $chantierID)->where('societe', $user->societeID)->where('categorie', 'interim')->get();
			
			$st = array();
			$sous_traitants = Mandat::where('societe', $user->societeID)->where('chantier', $chantierID)->get();
			foreach($sous_traitants as $sous_traitant)
				$st[] = $sous_traitant->mandataire;
			
			$st_int = Equipier::where('chantier', $chantierID)->whereIn('societe', $st)->whereIn('categorie', ['interim'])->get();
			
			$equipe_etr = Equipier::where('chantier', $chantierID)->where('societe', $user->societeID)->where('categorie', 'etranger')->get();
		}
		
		if($chantier->categorie == "virtuel")
			return view('chantier/equipe_virtuel', ['user' => $user, 'equipe' => $equipe, 'chantier' => $chantier, 'open' => 'chantier']);
		else
			return view('chantier/equipe', ['user' => $user, 'equipe' => $equipe, 'equipe_int' => $equipe_int, 'st_int' => $st_int, 'equipe_etr' => $equipe_etr, 'chantier' => $chantier, 'open' => 'chantier']);
    }
	
    public function enleverequipier(Request $request)
    {
		$user = \Auth::user();
		
		$myItem = Chantier::find($request->input("id"));
		
        $myTeammate = Equipier::find($request->input("entiteID"));
        $myTeammate->delete();
		
		return '<option id="ligneEntite_'.$myTeammate->intervenant.'" value="'.$myTeammate->intervenant.'">'.$myTeammate->name().'</option>';
    }
	
	/*** GESTION DES VEHICULES ***/
	
    public function vehicules($id)
    {
		$user = \Auth::user();
		
		$societeID = $user->societeID;
		
		$chantier = Chantier::find($id);
		$chantierID = $id;
		
		$page_title = 'Dossier '.$chantier->numero;
		$page_description = $chantier->numero;
		
		if($chantier->do == $user->societeID)
		{
			$titulaire = Societe::find($chantier->societe);
			$remplacants = array();

			$vehicules = Equipier::where('chantier', $chantierID)->where('categorie', 'vehicule')->get();
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
		
		// BOUTONS D'ACTIONS
		$actions = array();
		$actions[] = array("url" => "/chantier/show/".$chantier->id, "label" => "Informations", "style" => "info", "icon" => "<i class='fa fa-info'></i>");
		$actions[] = array("url" => "/chantier/intervenants/".$chantier->id, "label" => "Intervenants", "style" => "info", "icon" => "<i class='fa fa-user-friends'></i>");
		$actions[] = array("url" => "/chantier/vehicules/".$chantier->id, "label" => "Véhicules", "style" => "info", "icon" => "<i class='fa fa-truck'></i>");
		
		// SI ON EST UN ST DE NIV2 ON NE PEUT PAS VOIR CES BOUTONS
		
		$isTitulaire = Titulaire::where('chantier', $id)->where('societe', $user->societeID)->exists();
		if($isTitulaire)
		{
			$actions[] = array("url" => "/chantier/mandats/".$chantier->id, "label" => "Mandats", "style" => "info", "icon" => "<i class='fa fa-sitemap'></i>");
			$actions[] = array("url" => "/chantier/mandater/".$chantier->id, "label" => "Ajouter un prestataire", "style" => "info", "icon" => "<i class='fa fa-plus'></i>");
		}
		elseif($chantier->do == $user->id)
			$actions[] = array("url" => "/chantier/choixpresta/".$chantier->id, "label" => "Titulaires", "style" => "info", "icon" => "<i class='fa fa-plus'></i>");
		
		// BOUTONS DE POPUP
		$popups = array();
		$popups[] = array("target" => "kt_modal_prorogation", "icon" => "<i class='flaticon2-file text-muted'></i>");
		
		// BOUTONS DE NAVIGATION
		$navs = array();
		$navs[] = array("url" => "/chantier/sent", "label" => "Retour", "icon" => "<i class='fa fa-arrow-left'></i>");
		
        return view('chantier/affichage/vehicules', compact('page_title', 
		'page_description', 
		'user', 
		'actions', 
		'popups',
		'navs',
		'vehicules',
		'remplacants',
		'titulaire', 
		'chantier'));
    }
	
    public function vehicule($id)
    {
		$user = \Auth::user();
		
		$myItem = Equipier::find($id);
		$entite = Entite::find($myItem->intervenant);
		$chantier = Chantier::find($myItem->chantier);
		$chantiers = Equipier::where('intervenant', $entite->id)->get();

		$copies = $myItem->copies($myItem->chantier);
		
        return view('chantier/vehicule', ['user' => $user, 'entite' => $entite, 'vehicule' => $myItem, 'chantier' => $chantier, 'pieces' => array(), 'chantiers' => $chantiers, 'copies' => $copies, 'open' => 'chantier']);
    }
	
	public function validationvehicule(Request $request)
	{
		$user = \Auth::user();
		
		$myTeammate = Equipier::find($request->input("id"));
		$chantier = Chantier::find($myTeammate->chantier);
		
		// GESTION DE LA DOUBLE VALIDATION
		if($user->validation_forte())
		{
			if(!$myTeammate->validation1)
			{
				$myTeammate->validation1 = date('Y-m-d H:i:s');
				$myTeammate->auteur_validation1 = $user->id;
				$myTeammate->save();
			}
			elseif(!$myTeammate->validation2)
			{
				$myTeammate->validation2 = date('Y-m-d H:i:s');
				$myTeammate->auteur_validation2 = $user->id;
				$myTeammate->save();
				
				$myTeammate->validation = date('Y-m-d H:i:s');
				$myTeammate->auteur_validation = $user->id;
				$myTeammate->cle = $myTeammate->genererDocument();
				$myTeammate->save();
			}
		}
		
		// SI ON VIENT DU TABLEAU ON REFRESH QUE LE CADRE
		return view('chantier/validationvehicule', ['user' => $user, 'vehicule' => $myTeammate, 'chantier' => $chantier, 'open' => 'chantier']);
	}
	
	public function invalidervehicule(Request $request)
	{
		$user = \Auth::user();
		
		$myTeammate = Equipier::find($request->input("id"));
		$chantier = Chantier::find($myTeammate->chantier);
		
		$myTeammate->supprimerDocument();
		
		$myTeammate = Equipier::find($request->input("id"));
		$myTeammate->validation = date('Y-m-d H:i:s');
		$myTeammate->auteur_validation = $user->id;
		$myTeammate->cle = NULL;
		$myTeammate->save();
		
		return view('chantier/validationvehicule', ['user' => $user, 'vehicule' => $myTeammate, 'chantier' => $chantier, 'open' => 'chantier']);
	}
	
    public function savevehicule(Request $request)
    {
		$user = \Auth::user();
		
        $this->validate($request, ['immatriculation' => 'required']);

		// ON CREE L'ENTITE
        if($request->input("vehiculeID") <> 0)
		{
			$myItem = Entite::find($request->input("vehiculeID"));
		}
		else
		{
			$myItem = new Entite;
	        $myItem->name = $request->input("immatriculation");
	        $myItem->immatriculation = $request->input("immatriculation");
	        $myItem->modele = $request->input("modele");
	        $myItem->marque = $request->input("marque");
	        $myItem->type_vehicule = $request->input("type_vehicule");
	        $myItem->categorie = "vehicule";
	        $myItem->societe = $user->societeID;

	        $myItem->save();
		}	
		
		$chantier = Chantier::find($request->input("chantierID"));
		
		// ON AJOUTE LE VEHICULE DAN LE CHANTIER
        $myTeammate = new Equipier;
        $myTeammate->intervenant = $myItem->id;
        $myTeammate->chantier = $request->input("chantierID");
        $myTeammate->societe = $user->societeID;
        $myTeammate->chauffeur = $request->input("chauffeur");
        $myTeammate->type_transport = $request->input("type_transport");
        $myTeammate->motif = $request->input("motif");
        $myTeammate->do = $chantier->do;
		$myTeammate->categorie = "vehicule";
        $myTeammate->save();

		$myItem->chargerPieces($chantier->do);
		
		return $this->vehicules($request->input("chantierID"));
	}
	
    public function create($arg = array(), $message = "EMPTY")
    {
		$user = \Auth::user();
		
		$myItem = Societe::find($user->societeID);
		$typeChantiers = DoChantier::where('do', $user->societeID)->where('libelle', '!=', '')->get();
		$typeChantier = DoChantier::where('do', $user->societeID)->where('libelle', '!=', '')->first();
		
		if($typeChantier)
			$valideurs = User::whereIn('profil', [$typeChantier->profil_1, $typeChantier->profil_2, $typeChantier->profil_3])->get();
		else
			$valideurs = array();
					
		$infos = array();
		$infos["numero"] = (isset($arg["numero"])) ? $arg["numero"] : "";
		$infos["date_debut"] = (isset($arg["date_debut"])) ? $arg["date_debut"] : "";
		$infos["date_fin"] = (isset($arg["date_fin"])) ? $arg["date_fin"] : "";
		$infos["libelle"] = (isset($arg["libelle"])) ? $arg["libelle"] : "";
		$infos["responsable"] = (isset($arg["responsable"])) ? $arg["responsable"] : "";
		
		$prestataires = Societe::where('deleted', 0)->get();
		
		// BOUTONS DE NAVIGATION
		$navs = array();
		$navs[] = array("url" => "/chantier/sent", "label" => "Retour", "icon" => "<i class='fa fa-arrow-left'></i>");
		
        return view('chantier/actions/create', ['user' => $user, 'typeChantiers' => $typeChantiers, 'navs' => $navs, 'societe' => $myItem, 'infos' => $infos, 'message' => $message, 'valideurs' => $valideurs, 'prestataires' => $prestataires, 'open' => 'chantier']);
    }
	
	public function refreshresponsables(Request $request)
    {
		$typeChantier = DoChantier::find($request->id);
		$valideurs = User::whereIn('profil', [$typeChantier->profil_1, $typeChantier->profil_2, $typeChantier->profil_3])->get();
		
        return view('chantier/liste_responsables', ['valideurs' => $valideurs]);
    }
	
    public function createv($arg = array(), $message = "EMPTY")
    {
		$user = \Auth::user();
		
		$myItem = Societe::find($user->societeID);
		
		$infos = array();
		$infos["numero"] = (isset($arg["numero"])) ? $arg["numero"] : "";
		
		$prestataires = Societe::where('deleted', 0)->get();
		
        return view('chantier/createv', ['user' => $user, 'societe' => $myItem, 'infos' => $infos, 'message' => $message, 'prestataires' => $prestataires, 'open' => 'chantier']);
    }
	
    public function createpresta($arg = array(), $message = "EMPTY")
    {
		$user = \Auth::user();
		
		$myItem = Societe::find($user->societeID);
		$typeChantiers = DoChantier::where('do', $user->societeID)->where('libelle', '!=', '')->get();
		
		$infos = array();
		$infos["numero"] = (isset($arg["numero"])) ? $arg["numero"] : "";
		$infos["raison_sociale"] = (isset($arg["raison_sociale"])) ? $arg["raison_sociale"] : "";
		$infos["email"] = (isset($arg["email"])) ? $arg["email"] : "";
		$infos["date_debut"] = (isset($arg["date_debut"])) ? $arg["date_debut"] : "";
		$infos["date_fin"] = (isset($arg["date_fin"])) ? $arg["date_fin"] : "";
		$infos["libelle"] = (isset($arg["libelle"])) ? $arg["libelle"] : "";
		$infos["nom"] = (isset($arg["nom"])) ? $arg["nom"] : "";
		$infos["prenom"] = (isset($arg["prenom"])) ? $arg["prenom"] : "";
		
		$prestataires = Societe::where('deleted', 0)->get();
		
        return view('chantier/createpresta', ['user' => $user, 'typeChantiers' => $typeChantiers, 'societe' => $myItem, 'infos' => $infos, 'message' => $message, 'prestataires' => $prestataires, 'open' => 'chantier']);
    }
	
    public function createchantierdo($arg = array(), $message = "EMPTY")
    {
		$user = \Auth::user();
		
		$myItem = Societe::find($user->societeID);
		
		$infos = array();
		$infos["numero"] = (isset($arg["numero"])) ? $arg["numero"] : "";
		$infos["date_debut"] = (isset($arg["date_debut"])) ? $arg["date_debut"] : "";
		$infos["date_fin"] = (isset($arg["date_fin"])) ? $arg["date_fin"] : "";
		$infos["libelle"] = (isset($arg["libelle"])) ? $arg["libelle"] : "";
		$lesRessources = Entite::where('categorie', 'autre')->where('societe', $user->societeID)->get();
		$lesDo = Societe::where('fonctions_do', 1)->where('id', '<>', $user->societeID)->get();
		
        return view('chantier/createchantierdo', ['user' => $user, 'societe' => $myItem, 'infos' => $infos, 'message' => $message, 'lesRessources' => $lesRessources, 'open' => 'chantier']);
    }
	
    public function savechantierdo(Request $request)
    {
		$user = \Auth::user();
	
        $this->validate($request, ['numero' => 'required']);

		if(ChantierDo::where('numero', $request->input("numero"))->where('do', $user->societeID)->doesntExist() && $request->input("date_debut") <= $request->input("date_fin"))
		{
	        $myItem = new ChantierDo;
	        $myItem->numero = $request->input("numero");
	        $myItem->initiateur = $user->id;
	        $myItem->libelle = $request->input("libelle");
	        $myItem->date_debut = $request->input("date_debut");
	        $myItem->date_fin = $request->input("date_fin");
	        $myItem->do = $user->societeID;
	        $myItem->entite = $request->input("ressource");
 
	        $myItem->save();
		
			return $this->showDo($myItem->id);
		}
		else
		{
			$infos = array();
			$infos["numero"] = $request->input("numero");
			$infos["libelle"] = $request->input("libelle");
			$infos["date_debut"] = $request->input("date_debut");
			$infos["date_fin"] = $request->input("date_fin");
			$infos["validation_entite"] = $request->input("validation_entite");
			$infos["validation_rdv"] = $request->input("validation_rdv");
		
			return ($request->input("date_debut") > $request->input("date_fin")) ? $this->createchantierdo($infos, "DATE_ERROR") : $this->createchantierdo($infos, "ITEM_EXISTS");
		}
    }
	
	/*** GESTION DES PIECES ***/
	public function ajouterpiece(Request $request)
	{
		$user = \Auth::user();
		$entite = Entite::find($request->entite);
		$chantier = Chantier::find($request->chantier);
			
        $myPiece = new Piece;
        $myPiece->chantier = $request->chantier;
        $myPiece->do = $chantier->do;
        $myPiece->entite = $entite->intervenant;
        $myPiece->type_piece = $request->input("type_piece");
        $myPiece->date_expiration = $request->input("date_expiration");

		if ($request->hasFile('fichier'))
		{
			$name = $request->fichier->getClientOriginalName();
			$error = $request->fichier->move("pieces/".$entite->societe."/".$entite->id, $name);
			$myPiece->chemin = "pieces/".$entite->societe."/".$entite->id."/".$name;
			$myPiece->extension = $request->fichier->getClientOriginalExtension();

			$myPiece->save();
		}
		else
		{
			
		}
			
		$myTeammate = Equipier::find($request->input("equipier"));
		//$myTeammate->verifier();
		
		if($request->input("vehicule"))
			return $this->vehicules($request->input("chantier"));
		else
			return $this->intervenants($request->input("chantier"));
	}
	
    public function piece($id)
    {
		$user = \Auth::user();
		
		$copie = Piece::find($id);
		
		$headers = ['Content-Type' => 'application/pdf'];
		$myDirectory = "";
		
		return response()->download($copie->chemin);
	}
	
    public function pieces(Request $request)
    {
		$user = \Auth::user();
		
		$societes = Societe::all();
		
		$page_title = 'Pièces en attente';
		$page_description = "Pièces en attente de jugement";
		
		$keywords = "";
		$num_page = (isset($request->num_page)) ? $request->input("num_page") : 1;
		$sort = (isset($request->sort)) ? $request->input("sort") : "libelle";
		$sens = (isset($request->sens)) ? $request->input("sens") : "asc";
		$refresh = "/chantier/pieces";
		
		if(isset($request->keywords) && $request->keywords != "")
		{
			$keywords = $request->keywords;
			
			$elements = Piece::where('do', $user->societeID)->where('statut', 'attente')->where('libelle', 'like', '%'.$request->keywords.'%')->orderBy($sort, $sens)->offset(($num_page-1)*20)->limit(20)->get();
			$nb_items = Piece::where('do', $user->societeID)->where('statut', 'attente')->where('libelle', 'like', '%'.$request->keywords.'%')->count();
			$nb_pages = max(1, intval($nb_items/20));
		}
		else
		{
			$elements = Piece::where('do', $user->societeID)->where('statut', 'attente')->orderBy($sort, $sens)->offset(($num_page-1)*20)->limit(20)->get();
			$nb_items = Piece::where('do', $user->societeID)->where('statut', 'attente')->count();
			$nb_pages = max(1, intval($nb_items/20));
		}	
		
        return view('accueil/liste/piecesenattente', compact('page_title', 
		'page_description', 
		'user', 
		'keywords',
		'societes',
		'refresh',
		'num_page',
		'nb_pages', 
		'sort', 
		'sens', 
		'elements',
		'nb_items'));
    }
	
    public function piecesrefusees(Request $request)
    {
		$user = \Auth::user();
		
		$pieces = Piece::where('do', $user->societeID)->where('statut', 'refus')->get();
		
		return view('chantiers/piecesenattente', ['user' => $user, 'pieces' => $pieces, 'open' => 'chantier']);
    }
	
    public function entites(Request $request)
    {
		$user = \Auth::user();
		
		$entites = Validation::where('etat', 'attente')->where('do', $user->societeID)->get();
		
		return view('chantiers/entitesenattente', ['user' => $user, 'entites' => $entites, 'open' => 'chantier']);
    }
	
    public function validerentite($id)
    {
		$user = \Auth::user();
		
		$validation = Validation::find($id);
		$validation->auteur = $user->id;
		$validation->validation = time();
		$validation->etat = "valide";
		$validation->save();
		
		$entites = Validation::where('etat', 'attente')->where('do', $user->societeID)->get();
		
		return view('chantiers/entitesenattente', ['user' => $user, 'entites' => $entites, 'open' => 'chantier']);
    }
	
	public function decisionpiece($id)
	{
		$user = \Auth::user();
		
		$piece = Piece::find($id);
		$entite = Entite::find($piece->entite);
		$typesPieces = TypePiece::where('deleted', 0)->get();
		
		$filename = pathinfo($piece->chemin, PATHINFO_FILENAME);
		$extension = pathinfo($piece->chemin, PATHINFO_EXTENSION);
		
		if(file_exists(public_path($piece->chemin)))
		{
			$key = $piece->chemin;
			copy(public_path($piece->chemin), public_path("temp/".md5($key).".".$piece->extension));
			return view('chantiers/analyserpiece', ['user' => $user, 'entite' => $entite, 'piece' => $piece, 'typesPieces' => $typesPieces, 'key' => $key, 'extension' => $extension, 'message' => "EMPTY", 'open' => 'chantier']);
		}
		else
		{
			echo "Not copied : ".public_path($piece->chemin);
			return view('errors/404', ['user' => $user]);
		}
	}
	
	/*** AVIS DE RENDEZ VOUS ***/
    public function decisionrdv(Request $request)
    {
		$user = \Auth::user();
	
		$myItem = Rendezvous::find($request->input("id"));
		$myItem->validation = ($request->input("decision") == 'ok') ? $user->id : 0;
		$myItem->date_validation = date('Y-m-d H:i:s');
		$myItem->save();
		
		if($request->input("decision") == 'ok')
			return '<div class="alert alert-success fade show" role="alert">
		<div class="alert-icon"><i class="fa fa-check"></i></div>
		<div class="alert-text">La demande de rendez-vous a été acceptée</div>
	</div>
	<a class="btn btn-xs btn-info" href="/document/rdv/'.$request->input("id").'"><i class="fa fa-download"></i> Télécharger l\'avis</a>';
		else
			return '<div class="alert alert-danger fade show" role="alert">
		<div class="alert-icon"><i class="fa fa-times"></i></div>
		<div class="alert-text">La demande de rendez-vous a été refusée</div>
	</div>';
    }
	
    public function showrdv($rdvID)
    {
		$user = \Auth::user();
	
		$rdv = Rendezvous::find($rdvID);
		$visiteurs = json_decode($rdv->accompagnateurs);
		$creneaux = json_decode($rdv->creneaux);
		$disabled = ($rdv->validation) ? 'disabled' : '';
		
		$services = Service::where('societe', $user->societeID)->where('deleted', NULL)->get();
	
        return view('chantier/changeavis', compact('user', 'disabled', 'rdv', 'services', 'visiteurs', 'creneaux'));
    }
		
    public function avisrdv($arg = array(), $message = "EMPTY")
    {
		$user = \Auth::user();
		
		$myItem = Societe::find($user->societeID);
		
		$services = Service::where('societe', $user->societeID)->where('deleted', NULL)->get();
		
        return view('chantiers/createavis', ['user' => $user, 'societe' => $myItem, 'message' => $message, 'services' => $services]);
    }
	
	public function getlignevisiteur()
	{
		$identifiant = time();
		return view('chantiers/lignevisiteur', ["id" => $identifiant]);
	}
	
	public function getlignedate()
	{
		$identifiant = time();
		return view('chantiers/lignedate', ["id" => $identifiant]);
	}
	
    public function ajoutervisiteur()
    {
		$html = '';
		
		$html .= '
			<label class="col-lg-2 col-form-label">Nom *</label>
			<div class="col-lg-2">
				<input type="text" required name="nom_visiteur" class="form-control" placeholder="Nom">
			</div>
	
			<label class="col-lg-1 col-form-label">Prénom *</label>
			<div class="col-lg-2">
				<input type="text" required name="prenom_visiteur" class="form-control" placeholder="Prénom">
			</div>
	
			<label class="col-lg-1 col-form-label">Société *</label>
			<div class="col-lg-2">
				<input type="text" required name="societe_visiteur" class="form-control" placeholder="Société">
			</div>
			<div class="col-lg-2">
				<label class="col-lg-1 col-form-label"><i onclick="ajouterVisiteur();" class="fa fa-plus"></i></label>
			</div>';
			
			echo $html;
	}
	
	public function getavis($rdvID)
    {
		$user = \Auth::user();

		$myItem = Rendezvous::find($rdvID);

		$headers = ['Content-Type' => 'application/pdf'];
		$myDirectory = "";

		return Storage::download('documents/exemple/exemple.pdf', 'doc.pdf', $headers);
    }
	
	public function validerrdv(Request $request)
    {
		$user = \Auth::user();

		$myItem = Rendezvous::find($request->id);
		$myItem->validation = $user->id;
		$myItem->date_validation = time();
		$myItem->save();
		return "OK";
    }
	
	public function refuserrdv(Request $request)
    {
		$user = \Auth::user();

		$myItem = Rendezvous::find($request->id);
		$myItem->validation = 0;
		$myItem->date_validation = time();
		$myItem->save();
		return "KO";
    }
		
    public function rdv($message = "EMPTY")
    {
		$user = \Auth::user();
		
		$myItem = Societe::find($user->societeID);
		
		$societeID = $user->societeID;
		$myRdv = DB::table('equipiers')
			->whereNull('rdv')
			->whereIn('chantier', function($query) use ($societeID)
			    {
			        $query->select(DB::raw('chantier'))
			              ->from('chantiers')
			              ->whereRaw('chantiers.do = '.$societeID);
			    })
            ->get('equipiers.*');
		
		$rdvs = array();
		foreach($myRdv as $rdv)
		{
			$rdvs[] = Equipier::find($rdv->id);
		}
		
        return view('chantiers/rdv', ['user' => $user, 'societe' => $myItem, 'rdvs' => $rdvs, 'message' => $message]);
    }
	
    public function creerrdv(Request $request)
    {
		$user = \Auth::user();
		
       	$myItem = new Rendezvous();
        $myItem->nom_visiteur  = $request->nom_visiteur[0];
        $myItem->prenom_visiteur = $request->prenom_visiteur[0];
        $myItem->societe_visiteur = $request->societe_visiteur[0];
        $myItem->date_rdv = $request->date_rdv[0];
        $myItem->creneaux = json_encode($request->date_rdv);
        
		$accompagnement = array();
		$i = 0;
		foreach($request->nom_visiteur as $key => $visiteur)
		{
			$accompagnement[] = array("id" => $i, "nom" => $request->nom_visiteur[$key], "prenom" => $request->prenom_visiteur[$key], "societe" => $request->societe_visiteur[$key]);
			$i++;
		}
		
		$myItem->accompagnateurs = json_encode($accompagnement);
		
        $myItem->nom_do = $request->input("nom_do");
        $myItem->prenom_do = $request->input("prenom_do");
		
        $myItem->numero = "RDV".time();
        $myItem->initiateur = $user->name;
        $myItem->societe = $user->societeID;
        $myItem->service = $request->input("service");
        $myItem->commentaire = $request->input("commentaire");
 
        $myItem->save();
		
		return $this->lesavis($request);
    }
	
    public function lesavis(Request $request)
    {
		$user = \Auth::user();
		
		$keywords = "";
		$num_page = (isset($request->num_page)) ? $request->input("num_page") : 1;
		$sort = (isset($request->sort)) ? $request->input("sort") : "nom_visiteur";
		$sens = (isset($request->sens)) ? $request->input("sens") : "asc";
		
		if(isset($request->keywords) && $request->keywords != "")
		{
			$keywords = $request->keywords;
			
			$rdvs = Rendezvous::where('societe', $user->societeID)
				->where('nom_visiteur', 'like', '%'.$request->keywords.'%')
				->orWhere('prenom_visiteur', 'like', '%'.$request->keywords.'%')
				->orWhere('societe_visiteur', 'like', '%'.$request->keywords.'%')
				->orWhere('nom_do', 'like', '%'.$request->keywords.'%')
				->orWhere('prenom_do', 'like', '%'.$request->keywords.'%')
				->orderBy($sort, $sens)->offset(($num_page-1)*20)->limit(20)->get();
			
			$nb_rdvs = Rendezvous::where('societe', $user->societeID)->where('name', 'like', '%'.$request->keywords.'%')->get();
			$nb_pages = max(1, intval(sizeof($nb_rdvs)/20));
		}
		else
		{
			$rdvs = Rendezvous::where('societe', $user->societeID)->orderBy($sort, $sens)->offset(($num_page-1)*20)->limit(20)->get();
			
			$nb_rdvs = Rendezvous::where('societe', $user->societeID)->get();
			$nb_pages = max(1, intval(sizeof($nb_rdvs)/20));
		}	
		
		return view('chantiers/lesavis', ['user' => $user, 'rdvs' => $rdvs, 'open' => 'avis_rdv', 'keywords' => $keywords, 'nb_pages' => $nb_pages, 'num_page' => $num_page, 'sort' => $sort, 'sens' => $sens]);
	}

    public function attribuerpost(Request $request)
    {
		return $this->attribuer($request->input("id"));
	}
		
    public function attribuer($equipierID)
    {
		$user = \Auth::user();
		
		$equipier = Equipier::find($equipierID);
		$myItem = Chantier::find($equipier->chantier);
		$chantierID = $equipier->chantier;
			
		if($myItem->do == $user->societeID)
		{
			$equipe = Equipier::where('chantier', $chantierID)->get();
		}
		else
		{
			$equipe = Equipier::where('chantier', $chantierID)->where('societe', $user->societeID)->where('categorie', 'intervenant')->get();
		}
		
		$creneaux = Creneau::where('societe', $myItem->do)->get();
		
        return view('chantier/attribuer', ['user' => $user, 'equipe' => $equipe, 'creneaux' => $creneaux, 'chantier' => $myItem, 'equipier' => $equipier]);
    }
	//enregistre un creneau dans la table equipier et return la date du creneau
    public function setcreneau(Request $request)
    {
		$user = \Auth::user();

		$creneau = Creneau::find($request->input("creneau"));

		$equipier = Equipier::find($request->input("equipierID"));
		if(Equipier::where('rdv',$creneau->id)->count() < $creneau->nombre_places){
			$equipier->creneau = $request->input("creneau");
			$equipier->rdv = $creneau->id;
			$equipier->save();
		
			return $creneau->date_debut;
		}
		
		return 'IL n\'y a plus de place disponible pour ce créneau !';
		
	}
	public function rafraichircalendar(Request $request)
	{
		$equipier = Equipier::find($request->equipier);
		$creneaux = Creneau::where('societe', $equipier->do)->get();
		
		return view('chantier/rafraichircalendar', ['creneaux' => $creneaux,'equipier' => $equipier]);
	}
	//annule un rdv et lance le rafraichissement du calendar
	public function annulerrdv(Request $request)
	{
		$equipier = Equipier::find($request->equipier);
		$creneaux = Creneau::where('societe', $equipier->do)->get();
		 $equipier->rdv=Null;
		 $equipier->save();
		
		return view('chantier/rafraichircalendar', ['creneaux' => $creneaux,'equipier' => $equipier]);
	}
	/*** ADMIN ***/
	
    public function administrerchantier()
    {
		$user = \Auth::user();
		
		$chantiers = TypeChantier::where('deleted', 0)->get();
		return view('chantiers/lister', ['user' => $user, 'chantiers' => $chantiers]);
    }
	
    public function addtypechantiers()
    {
		$user = \Auth::user();
		
		$pieces = TypePiece::where('deleted', 0)->get();
		
		return view('chantiers/ajouter', ['user' => $user, 'pieces' => $pieces]);
    }
	
    public function savechantiers(Request $request)
    {
		$user = \Auth::user();
		
        $myTeammate = new TypeChantier;
        $myTeammate->libelle = $request->input("libelle");
        $myTeammate->abbreviation = $request->input("abbreviation");
        $myTeammate->pieces_obligatoires = json_encode($request->input("obligatoire"));
        $myTeammate->pieces_optionnelles = $request->input("optionnelles");
 
        $myTeammate->save();
		
		return $this->administrerchantier();
    }
}