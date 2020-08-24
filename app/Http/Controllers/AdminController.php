<?php

namespace App\Http\Controllers;

use App\Chantier;
use App\Copie;
use App\DoChantier;
use App\Detachement;
use App\Entite;
use App\Evenement;
use App\Notification;
use App\Pays;
use App\Piece;
use App\Profil;
use App\Societe;
use App\Service;
use App\Titulaire;
use App\TypePiece;
use App\TypeChantier;
use App\TypeLivraison;
use App\User;
use App\Zone;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
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

    public function do()
    {
		$user = \Auth::user();
		
		$comptes = User::where('do', 1)->where('groupe', 'user')->get();
			
        return view('admin/do', ['user' => $user, 'comptes' => $comptes, 'open' => 'do']);
    }
	
    public function create_do()
    {
		$user = \Auth::user();
		
		$societe = new Societe;
			
        return view('admin/create-do', ['user' => $user, 'societe' => $societe, 'open' => 'do']);
    }
	
    public function pays()
    {
		$user = \Auth::user();
		
		$elements = Pays::orderBy('libelle')->get();
			
        return view('admin/pays', compact('user', 'elements'));
    }
	
	public function profils()
	{
		$user = \Auth::user();
		
		$zones = Zone::orderBy('libelle')->get();
		$pieces = TypePiece::orderBy('libelle')->where('etranger', 1)->get();
		$detachement = new Detachement();
			
        return view('admin/detachements', compact('user', 'zones', 'pieces', 'detachement'));
	}
	
    public function unpays($id)
    {
		$user = \Auth::user();
		
		$pays = Pays::find($id);
		$zones = Zone::orderBy('libelle')->get();
			
        return view('admin/unpays', compact('user', 'pays', 'zones'));
    }
	
    public function savepays(Request $request)
    {
		$user = \Auth::user();
		
		$pays = Pays::find($request->id);
		$pays->libelle = $request->libelle;
		$pays->code = $request->code;
		$pays->zone = $request->zone;
		$pays->save();
			
        return $this->pays();
    }
	
    public function zonesgeo()
    {
		$user = \Auth::user();
		
		$elements = Zone::orderBy('libelle')->get();
			
        return view('admin/zonesgeo', compact('user', 'elements'));
    }
	
    public function enregistrerpieces(Request $request)
    {
		$user = \Auth::user();
	
		$detachement = Detachement::where('zone_soc', $request->soc)->where('zone_ent', $request->ent)->first();
		if($detachement)
		{
			$str = '';
			$pieces = json_decode($request->value);
			if($pieces)
			{
				foreach($pieces as $piece)
				{
					$str .= $piece->value.',';
				}
			}
			
			$detachement->pieces = substr($str, 0, -1);
			$detachement->save();
		}
    }
	
    public function unezone($id)
    {
		$user = \Auth::user();
		
		$zone = Zone::find($id);
			
        return view('admin/unezone', compact('user', 'zone'));
    }
	
    public function savezone(Request $request)
    {
		$user = \Auth::user();
		
		$zone = zone::find($request->id);
		$zone->libelle = $request->libelle;
		$zone->save();
			
        return $this->zonesgeo();
    }
	
    public function adddo(Request $request)
    {
		// SI LA SOCIETE EST A 0 ON VA LA CREER SINON ON LA MET A JOUR
		$mySociety = new Societe();
		$mySociety->raisonSociale = $request->input("raison_sociale");
		$mySociety->noSiret = $request->input("no_siret");
		$mySociety->telephone = $request->input("telephone");
		$mySociety->email = $request->input("email");
		$mySociety->adresse = $request->input("adresse");
		$mySociety->complement = $request->input("complement");
		$mySociety->codePostal = $request->input("code_postal");
		$mySociety->ville = $request->input("ville");
		$mySociety->pays = $request->input("pays");
		$mySociety->save();
		
		$myItem = new User;
        $myItem->name = trim($request->input("nom")." ".$request->input("prenom"));
        $myItem->nom = $request->input("nom");
        $myItem->prenom = $request->input("prenom");
        $myItem->telephone = $request->input("telephone");
        $myItem->email = $request->input("email");
        $myItem->do = 1;
        $myItem->groupe = 'user';
        $myItem->societeID = $mySociety->id;
		
		$mypass = $request->input("password");
        $myItem->password = Hash::make($mypass);
        $myItem->fonction = $mypass;
 
    	$myItem->save();
		
		return $this->do();
    }
	
    public function chantier($id)
    {
		$user = \Auth::user();
		
		$chantier = Chantier::find($id);
		$titulaire = Societe::find($chantier->societe);
		$titulaires = Titulaire::where('chantier', $id)->get();
		$evenements = Evenement::where('chantier', $id)->get();
			
        return view('admin/view-chantier', ['user' => $user, 'titulaire' => $titulaire, 'chantier' => $chantier, 'evenements' => $evenements, 'titulaires' => $titulaires, 'open' => 'chantier']);
    }
	
    public function type_chantier()
    {
		$user = \Auth::user();
		
		$type_chantier = TypeChantier::all();
			
        return view('admin/type-chantier', ['user' => $user, 'type_chantiers' => $type_chantier, 'open' => 'parametres']);
    }
	
    public function ajoutertype(Request $request)
    {
		$user = \Auth::user();
		
		$type_chantier = new TypeChantier();
		$type_chantier->libelle = $request->input("libelle");
		$type_chantier->niveau_validation = $request->input("niveau_validation");
		$type_chantier->save();
				
        return $this->type_chantier();
    }
	
    public function supprimertype($id)
    {
		$user = \Auth::user();
		
		$type_chantiers = DoChantier::where('type_chantier', $id)->get();
		if($type_chantiers)
		{
			// DO NOTHING
		}
		else
		{
			$type_chantier = TypeChantier::find($id);
			$type_chantier->delete();
		}
				
        return $this->type_chantier();
    }
	
    public function type_livraison()
    {
		$user = \Auth::user();
		
		$type_livraison = TypeLivraison::all();
			
        return view('admin/type-livraison', ['user' => $user, 'type_chantiers' => $type_livraison, 'open' => 'parametres']);
    }
	
    public function ajoutertypelivraison(Request $request)
    {
		$user = \Auth::user();
		
		$type_chantier = new TypeLivraison();
		$type_chantier->libelle = $request->input("libelle");
		$type_chantier->niveau_validation = $request->input("niveau_validation");
		$type_chantier->save();
				
        return $this->type_livraison();
    }
	
    public function supprimertypelivraison($id)
    {
		$user = \Auth::user();
		
		$type_chantiers = Livraison::where('type_chantier', $id)->get();
		if($type_chantiers)
		{
			// DO NOTHING
		}
		else
		{
			$type_chantier = TypeLivraison::find($id);
			$type_chantier->delete();
		}
				
        return $this->type_livraison();
    }
	
    public function chantiers()
    {
		$user = \Auth::user();
		
		$chantiers = Chantier::where('societe', $user->societeID)->get();
		$keywords = "";
		
        return view('do/inprogress', ['user' => $user, 'chantiers' => $chantiers, 'open' => 'chantier', 'keywords' => $keywords]);
    }
	
    public function notifpresta()
    {
		$user = \Auth::user();
		
		$notifications = Notification::where('do', 0)->orderBy('created_at', 'desc')->get();
		
        return view('admin/notifications', ['user' => $user, 'notifications' => $notifications, 'open' => 'notifications']);
    }
	
    public function notifdo()
    {
		$user = \Auth::user();
		
		$notifications = Notification::where('do', 1)->orderBy('created_at', 'desc')->get();
		
        return view('admin/notifications', ['user' => $user, 'notifications' => $notifications, 'open' => 'notifications']);
    }
	
	public function inprogress(Request $request)
	{
		$user = \Auth::user();
		
		$results = Chantier::where('date_fin', '>', time())->get();
		$results2 = DB::table('chantiers')->get();
		$keywords = $request->input("keywords");
		
		$meta = array();
		$meta["page"] = $request->pagination["page"];
		$meta["pages"] = count($results2);
		$meta["perpage"] = $request->pagination["perpage"];
		$meta["total"] = count($results2);
		$meta["sort"] = $request->sort["sort"];
		$meta["field"] = $request->sort["field"];
		
		$response = array();
		$response["meta"] = $meta;
		
		$data = array();
		foreach($results as $myChantier)
		{
			$chantier["ChantierID"] = $myChantier->id;
			$chantier["Numero"] = $myChantier->numero;
			$chantier["Type"] = $myChantier->type_chantier();
			$chantier["Initiateur"] = $myChantier->initiateur();
			$chantier["Responsable"] = "";
			$chantier["Prestataire"] = $myChantier->titulaire();
			$chantier["Date"] = date('d/m/Y', strtotime($myChantier->date_debut));
			$chantier["Statut"] = $myChantier->statut();
			$chantier["state"] = "";
			$chantier["Actions"] = "";
			
			$data[] = $chantier;
		}
		
		$response["data"] = $data;
		
		return json_encode($response);
	}
	
    public function old()
    {
		$user = \Auth::user();
		
		$chantiers = Chantier::where('societe', $user->societeID)->get();
		$keywords = "";
		
        return view('do/old', ['user' => $user, 'chantiers' => $chantiers, 'open' => 'chantier', 'keywords' => $keywords]);
    }
	
	public function oldchantiers(Request $request)
	{
		$user = \Auth::user();
		
		$results = Chantier::where('date_fin', '<', time())->get();
		$keywords = $request->input("keywords");
		
		$meta = array();
		$meta["page"] = $request->pagination["page"];
		$meta["pages"] = 15;
		$meta["perpage"] = 30;
		$meta["total"] = 300;
		$meta["sort"] = "asc";
		$meta["field"] = "Numero";
		
		$response = array();
		$response["meta"] = $meta;
		
		$data = array();
		foreach($results as $myChantier)
		{
			$chantier["ChantierID"] = $myChantier->id;
			$chantier["Numero"] = $myChantier->numero;
			$chantier["Type"] = 2;
			$chantier["Initiateur"] = $myChantier->initiateur();
			$chantier["Responsable"] = "";
			$chantier["Prestataire"] = $myChantier->titulaire();
			$chantier["Date"] = date('d/m/Y', strtotime($myChantier->date_debut));
			$chantier["Statut"] = "";
			$chantier["state"] = "";
			$chantier["Actions"] = "";
			
			$data[] = $chantier;
		}
		
		$response["data"] = $data;
		
		return json_encode($response);
	}
	
    public function pieces(Request $request)
    {
		$user = \Auth::user();
		
		$pieces = Copie::where('etat', 'attente')->get();
		
		return view('do/piecesenattente', ['user' => $user, 'pieces' => $pieces, 'open' => 'chantier']);
    }
	
	public function decisionpiece($id)
	{
		$user = \Auth::user();
		
		$piece = Copie::find($id);
		$chantier = Chantier::find($piece->chantier);
		$entite = Entite::find($piece->entite);
		$typesPieces = TypePiece::where('deleted', 0)->get();
		
		$filename = pathinfo($piece->chemin, PATHINFO_FILENAME);
		$extension = pathinfo($piece->chemin, PATHINFO_EXTENSION);
		
		if(!file_exists("/storage/public/tmp/".$filename.".".$extension))
		//	copy("/var/www/vhosts/oasis-dev.pro/recette.oasis-dev.pro".$piece->chemin, "/var/www/vhosts/oasis-dev.pro/recette.oasis-dev.pro/public/assets/temp/".$filename.".".$extension);
			copy("/Users/jgd/Documents/Serveur3/apache2/serverPhp7/oasis/storage/app/".$piece->chemin, "/Users/jgd/Documents/Serveur3/apache2/serverPhp7/oasis/public/assets/temp/".$filename.".".$extension);
		
		return view('admin/analyserpiece', ['user' => $user, 'entite' => $entite, 'piece' => $piece, 'typesPieces' => $typesPieces, 'chantier' => $chantier, 'file' => '/temp/'.$filename.'.'.$extension, 'extension' => $extension, 'message' => "EMPTY"]);
	}
	
	/*** PRESTATAIRES ***/
    public function changerstatut(Request $request)
    {
		$user = \Auth::user();
		
		$societe = Societe::find($request->id);
		$societe->active = $request->value;
		
		if($request->value == 1)
		{
			$compte = $societe->compte();
			$compte->expires = date("Y-m-d H:i:s", strtotime(date("Y-m-d")."+6months"));
			$compte->save();
		}	
		
		$societe->save();
		
		return view('admin/statut', ['user' => $user, 'societe' => $societe]);
    }
	
    public function resetpassword(Request $request)
    {
		$user = \Auth::user();
		
		$societe = Societe::find($request->id);
		
		$compte = $societe->compte();
		
		$mypass = "Password*";
		$compte->password = Hash::make($mypass);
		$compte->expires = date("Y-m-d H:i:s", strtotime(date("Y-m-d")."+6months"));
		$compte->save();
		
		return $mypass;
    }
	
	public function prestataires(Request $request)
    {
		$user = \Auth::user();
		
		$keywords = "";
		$request->session()->put('statut', 'all');
		
        return view('admin/view-presta', ['user' => $user, 'keywords' => $keywords, 'open' => 'presta']);
    }
	
    public function prestataires2(Request $request)
    {
		$user = \Auth::user();
		
		$keywords = "";
		$request->session()->put('statut', $request->statut);
		
        return view('admin/view-presta', ['user' => $user, 'keywords' => $keywords, 'open' => 'presta']);
    }
	
	public function listepresta(Request $request)
	{
		$user = \Auth::user();
		
		$selectedStatut = $request->session()->pull('statut', 'all');
		
		if($selectedStatut == 'all')
			$results = DB::table('societes')->offset(($request->pagination["page"]-1)*$request->pagination["perpage"])->limit($request->pagination["perpage"])->get();
		else
			$results = DB::table('societes')->where('active', $selectedStatut)->offset(($request->pagination["page"]-1)*$request->pagination["perpage"])->limit($request->pagination["perpage"])->get();
		
		$results2 = DB::table('societes')->get();
		
		$keywords = $request->input("keywords");
		
		$meta = array();
		$meta["page"] = $request->pagination["page"];
		$meta["pages"] = count($results2);
		$meta["perpage"] = $request->pagination["perpage"];
		$meta["total"] = count($results2);
		$meta["sort"] = $request->sort["sort"];
		$meta["field"] = $request->sort["field"];
		
		$response = array();
		$response["meta"] = $meta;
		
		$data = array();
		foreach($results as $mySociete)
		{
			$societe["SocieteID"] = $mySociete->id;
			$societe["noSiret"] = $mySociete->noSiret;
			$societe["raisonSociale"] = $mySociete->raisonSociale;
			$societe["active"] = $mySociete->active;
			$societe["created_at"] = date("d/m/Y", strtotime($mySociete->created_at));
			$societe["Abonnement"] = 1;
			$societe["Actions"] = "";
			
			$data[] = $societe;
		}
		
		$response["data"] = $data;
		
		return json_encode($response);
	}
	
    public function showpresta($id)
    {
		$user = \Auth::user();
		
		$prestataire = Societe::find($id);
			
        return view('admin/prestataire', ['user' => $user, 'societe' => $prestataire, 'open' => 'presta']);
    }
}
