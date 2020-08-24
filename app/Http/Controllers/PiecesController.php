<?php

namespace App\Http\Controllers;

use App\Chantier;
use App\Equipier;
use App\Entite;
use App\Habilitation;
use App\Notification;
use App\Piece;
use App\TypePiece;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\FileNotFoundException;

class PiecesController extends Controller
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
	
    public function administrer()
    {
		$user = \Auth::user();
		
		$pieces = TypePiece::where('deleted', 0)->get();
		return view('pieces/lister', ['user' => $user, 'pieces' => $pieces, 'open' => 'parametres']);
    }
	
    public function fiche($id)
    {
		$user = \Auth::user();
		
		$typePiece = TypePiece::find($id);
		
		return view('pieces/fiche', ['user' => $user, 'typePiece' => $typePiece, 'open' => 'parametres']);
    }
	
    public function add()
    {
		$user = \Auth::user();
		
		$typePiece = new TypePiece;
		
		return view('pieces/ajouter', ['user' => $user, 'typePiece' => $typePiece, 'open' => 'parametres']);
    }
	
    public function savetypepiece(Request $request)
    {
		$user = \Auth::user();
        $myTeammate = TypePiece::find($request->input("id"));
        $myTeammate->libelle = $request->input("libelle");
        $myTeammate->abbreviation = $request->input("abbreviation");

        $myTeammate->intervenant = ($request->input("intervenant") == "on") ? 1 : 0;
        $myTeammate->chantier = ($request->input("chantier") == "on") ? 1 : 0;
        $myTeammate->interim = ($request->input("interim") == "on") ? 1 : 0;
        $myTeammate->etranger = ($request->input("etranger") == "on") ? 1 : 0;
        $myTeammate->vehicule = ($request->input("vehicule") == "on") ? 1 : 0;
        $myTeammate->livreur = ($request->input("livreur") == "on") ? 1 : 0;
        $myTeammate->livraison = ($request->input("livraison") == "on") ? 1 : 0;

        $myTeammate->save();
	
		return $this->administrer();
    }
	
    public function savepieces(Request $request)
    {
		$user = \Auth::user();
		
        $myTeammate = new TypePiece;
        $myTeammate->libelle = $request->input("libelle");
        $myTeammate->abbreviation = $request->input("abbreviation");
        $myTeammate->icone = $request->input("icone");
        $myTeammate->formats = $request->input("formats");
        //$myTeammate->recto_verso = $request->input("recto_verso");
 
        $myTeammate->save();
		
		return $this->administrer();
    }
	
    public function habilitations()
    {
		$user = \Auth::user();
	
		$habilitations = Habilitation::all();
		return view('pieces/habilitations', ['user' => $user, 'habilitations' => $habilitations, 'open' => 'parametres']);
    }
	
    public function addhabilitation()
    {
		$user = \Auth::user();
	
		return view('pieces/addhabilitation', ['user' => $user, 'open' => 'parametres']);
    }
	
    public function deletehabilitation($id)
    {
		$user = \Auth::user();
	
		$habilitation = Habilitation::find($id);
		if($habilitation)
			$habilitation->delete();
	
		return $this->habilitations();
    }
			
    public function fichehabilitation($id)
    {
		$user = \Auth::user();
		
		$habilitation = Habilitation::find($id);
		
		return view('pieces/fichehabilitation', ['user' => $user, 'habilitation' => $habilitation, 'open' => 'parametres']);
    }
	
    public function savehabilitation(Request $request)
    {
		$user = \Auth::user();
        $habilitation = ($request->input("id") == 0) ? new Habilitation : Habilitation::find($request->input("id"));
        $habilitation->libelle = $request->input("libelle");
        $habilitation->save();
	
		return $this->habilitations();
    }
	
    public function validerpiece(Request $request)
    {
		$user = \Auth::user();
		
		$piece = Piece::find($request->input("id"));
		
		$piece->statut = $request->input("etat");
		$piece->date_expiration = $request->input("date_expiration");
		$piece->commentaire = $request->input("commentaire");
		$piece->save();
		
		$entite = Entite::find($piece->entite);
		$entite->verifier($user->societeID);
		
		return view('chantiers/zonedecision', ['user' => $user, 'piece' => $piece]);
	}
}