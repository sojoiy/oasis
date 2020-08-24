<?php

namespace App\Http\Controllers;

use App\ZoneAcces;
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

class RdvController extends Controller
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
	
    public function lister(Request $request)
    {
		$user = \Auth::user();
		
		$keywords = "";
		$num_page = (isset($request->num_page)) ? $request->input("num_page") : 1;
		$sort = (isset($request->sort)) ? $request->input("sort") : "nom_visiteur";
		$sens = (isset($request->sens)) ? $request->input("sens") : "asc";
		$refresh = "/rdv/lister";
		
		$page_title = 'Rendez-vous ';
		$page_description = '';
		
		if(isset($request->keywords) && $request->keywords != "")
		{
			$keywords = $request->keywords;
			
			$elements = Rendezvous::where('societe', $user->societeID)
				->where('nom_visiteur', 'like', '%'.$request->keywords.'%')
				->orWhere('prenom_visiteur', 'like', '%'.$request->keywords.'%')
				->orWhere('societe_visiteur', 'like', '%'.$request->keywords.'%')
				->orWhere('nom_do', 'like', '%'.$request->keywords.'%')
				->orWhere('prenom_do', 'like', '%'.$request->keywords.'%')
				->orderBy($sort, $sens)->offset(($num_page-1)*20)->limit(20)->get();
			
			$nb_items = Rendezvous::where('societe', $user->societeID)->where('name', 'like', '%'.$request->keywords.'%')->count();
			$nb_pages = max(1, intval($nb_items/20));
		}
		else
		{
			$elements = Rendezvous::where('societe', $user->societeID)->where('initiateur', $user->name)->orderBy($sort, $sens)->offset(($num_page-1)*20)->limit(20)->get();
			
			$nb_items = Rendezvous::where('societe', $user->societeID)->where('initiateur', $user->name)->count();
			$nb_pages = max(1, intval($nb_items/20));
		}	
		
		// BOUTONS D'ACTIONS
		$actions = array();
		$actions[] = array("url" => "/rdv/creer", "label" => "Nouveau RDV", "style" => "info", "icon" => "<i class='fa fa-plus'></i>");
		$actions[] = array("url" => "/rdv/lister", "label" => "Tous les Avis", "style" => "info", "icon" => "<i class='fa fa-list'></i>");
		
        return view('rdv/liste/lesavis', compact('page_title', 
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
		
		$page_title = 'Rendez-vous';
		$page_description = '';
		
		$visiteurs = json_decode($rdv->accompagnateurs);
		$creneaux = json_decode($rdv->creneaux);
		$disabled = ($rdv->validation) ? 'disabled' : '';
		
		$zones = ZoneAcces::where('societe', $user->societeID)->where('deleted', NULL)->get();
		$services = Service::where('societe', $user->societeID)->where('deleted', NULL)->get();
		$profils = DB::table('profils')->select('id')->where('validation_entites', 1)->get();
		foreach($profils as $arr)
			$args[] = $arr->id;
		$users = User::whereIn('profil', $args)->where('societeID', $user->societeID)->get();
		
		// BOUTONS DE NAVIGATION
		$navs = array();
		$navs[] = array("url" => "/rdv/lister", "label" => "Retour", "icon" => "<i class='fa fa-arrow-left'></i>");
		
		
		return view('rdv/affichage/show', compact('page_title', 
		'page_description',
		'user',
		'zones',
		'navs',
		'disabled',
		'services',
		'visiteurs',
		'users',
		'creneaux',
		'rdv'));
    }
		
    public function creer($arg = array(), $message = "EMPTY")
    {
		$user = \Auth::user();
		
		$page_title = 'Rendez-vous';
		$page_description = '';
		
		$societe = Societe::find($user->societeID);
		
		$zones = ZoneAcces::where('societe', $user->societeID)->where('deleted', NULL)->get();
		$services = Service::where('societe', $user->societeID)->where('deleted', NULL)->get();
		$profils = DB::table('profils')->select('id')->where('validation_entites', 1)->get();
		foreach($profils as $arr)
			$args[] = $arr->id;
		$users = User::whereIn('profil', $args)->where('societeID', $user->societeID)->get();
		
		// BOUTONS DE NAVIGATION
		$navs = array();
		$navs[] = array("url" => "/rdv/lister", "label" => "Retour", "icon" => "<i class='fa fa-arrow-left'></i>");
		
		return view('rdv/actions/creer', compact('page_title', 
		'page_description',
		'user',
		'navs',
		'users',
		'zones',
		'societe',
		'services',
		'message'));
    }
	
	public function listeValideur(Request $request)
	{
		$profils = DB::table('profils')->select('id')->where('validation_entites', 1)->get();
		foreach($profils as $arr)
			$args[] = $arr->id;
		$users = User::whereIn('profil', $args)->get();
		
		return view('rdv/liste/listevalideurs', ["users" => $users]);
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
		$myItem->date_validation = date("Y-m-d H:i");
		$myItem->save();
		return "OK";
    }
	
	public function refuserrdv(Request $request)
    {
		$user = \Auth::user();

		$myItem = Rendezvous::find($request->id);
		$myItem->validation = 0;
		$myItem->date_validation = date("Y-m-d H:i");
		$myItem->save();
		return "KO";
    }
	
	public function supprimer(Request $request)
    {
		$user = \Auth::user();

		$myItem = Rendezvous::find($request->id);
		$myItem->delete();
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
        $myItem->valideur = $request->valideur;
		
		if($request->valideur2)
        	$myItem->valideur2 = $request->valideur2;
		
        $myItem->zone = $request->zone;
        $myItem->societe_externe = $request->societe;
		
		// ON MET A JOUR LE VALIDEUR DU COMPTE
		$user->dernier_valideur = $request->valideur;
		$user->save();
		
        $myItem->service = $request->input("service");
        $myItem->commentaire = $request->input("commentaire");
        $myItem->save();
		
		return $this->lister($request);
    }
	
    public function save(Request $request)
    {
		$user = \Auth::user();
		
       	$myItem = Rendezvous::find($request->id);
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
		
		if($request->valideur2)
        	$myItem->valideur2 = $request->valideur2;
		
        $myItem->zone = $request->zone;
        $myItem->societe_externe = $request->societe;
		
		// ON MET A JOUR LE VALIDEUR DU COMPTE
		$user->dernier_valideur = $request->valideur;
		$user->save();
        $myItem->numero = "RDV".time();
        $myItem->initiateur = $user->name;
        $myItem->societe = $user->societeID;
        $myItem->valideur = $request->valideur;
        $myItem->service = $request->input("service");
        $myItem->commentaire = $request->input("commentaire");
 
        $myItem->save();
		
		return $this->lister($request);
    }
	
    
}