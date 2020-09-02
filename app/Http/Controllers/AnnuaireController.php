<?php

namespace App\Http\Controllers;

use App\Chantier;
use App\Equipier;
use App\Entite;
use App\Habilitation;
use App\EntiteHabilitation;
use App\Notification;
use App\Piece;
use App\TypePiece;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\FileNotFoundException;

class AnnuaireController extends Controller
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
	
	// AFFICHE LA LISTE DES INTERVENANTS QUI ONT ETE SUR UN CHANTIER DU DO
	// annuaire/lister
    public function lister($message = "EMPTY", Request $request)
    {
		$user = \Auth::user();
		
		$page_title = 'Annuaire intervenants';
        $page_description = "";
		
		$keywords = "";
		$num_page = (isset($request->num_page)) ? $request->input("num_page") : 1;
		$sort = (isset($request->sort)) ? $request->input("sort") : "name";
		$sens = (isset($request->sens)) ? $request->input("sens") : "asc";
		$refresh = "/annuaire/lister";
		
		if(isset($request->keywords) && $request->keywords != "")
		{
			$keywords = $request->keywords;
			
			$elements = Entite::where('name', 'like', '%'.$request->keywords.'%')->orderBy($sort, $sens)->offset(($num_page-1)*20)->limit(20)->get();
			$nb_items = Entite::where('name', 'like', '%'.$request->keywords.'%')->orderBy($sort, $sens)->offset(($num_page-1)*20)->limit(20)->count();
			
			$nb_pages = max(1, intval($nb_items/20));
		}
		else
		{
			$elements = Entite::orderBy($sort, $sens)->offset(($num_page-1)*20)->limit(20)->get();
			$nb_items = Entite::orderBy($sort, $sens)->offset(($num_page-1)*20)->limit(20)->count();
			
			$nb_pages = max(1, intval($nb_items/20));
		}
		
		$actions = array();
		
        return view('annuaire/liste/lister', compact('page_title', 
		'page_description', 
		'refresh',
		'actions', 
		'user', 
		'keywords', 
		'nb_pages', 
		'num_page', 
		'sort', 
		'sens', 
		'elements',
		'nb_items')); 
    }
	
	// AFFICHE LA FICHE D'UNE ENTITE
	// annauire/show
    public function show($id = "EMPTY", Request $request)
    {
		$user = \Auth::user();
		
		$page_title = 'Annuaire intervenants';
        $page_description = "";
		
		$user = \Auth::user();
		
		$entite = Entite::find($id);

		echo 
		$copies = Piece::where('entite', $entite->id)->where('do', $user->societeID)->get();
		$chantiers = array();
		$lesPays = array();
		$typesPieces = array();
		$habilitations = EntiteHabilitation::where('entite', $id)->get();
		
		// BOUTONS D'ACTIONS
		$actions = array();
		
		// BOUTONS DE POPUP
		$popups = array();
		
		// BOUTONS DE NAVIGATION
		$navs = array();
		$navs[] = array("url" => "/annuaire/lister", "label" => "Retour", "icon" => "<i class='fa fa-arrow-left'></i>");
		
        return view('annuaire/affichage/intervenant', compact('page_title', 
		'page_description', 
		'user', 
		'actions', 
		'popups',
		'navs',
		'entite', 
		'chantiers', 
		'copies',
		'lesPays',
		'typesPieces',
		'chantiers',
		'habilitations'));
    }
}