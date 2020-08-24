<?php

namespace App\Http\Controllers;

use App\Entite;
use App\Lien;
use App\Chantier;
use App\DoChantier;
use App\DoLivraison;
use App\Document;
use App\Profil;
use App\Societe;
use App\Pays;
use App\User;
use App\Habilitation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Input;
use League\Flysystem\FileNotFoundException;
use Illuminate\Support\Facades\Hash;

class SocietesController extends Controller
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
	
    public function completerprofil()
    {
		$user = \Auth::user();
		
		$myItem = Societe::find($user->societeID);
		$type_chantier_good = 0;
		
		// CALCUL DU NOMBRE DE GROUPES
		$nombre_groupes = Profil::where('societe', $user->societeID)->count();
		$comptes_acc = User::where('societeID', $user->societeID)->where('validation_pieces', 1)->count();
		$comptes_vg = User::where('societeID', $user->societeID)->where('validation_globale', 1)->count();
		$type_chantier_good = DoChantier::where('do', $user->societeID)->count();
		$type_livraisons_good = DoLivraison::where('do', $user->societeID)->count();
		$initier_chantiers = Profil::where('societe', $user->societeID)->where('initier_chantier', 1)->count();
		$valideur_intervenants = Profil::where('societe', $user->societeID)->where('validation_entites', 1)->count();
		$initier_livraison = Profil::where('societe', $user->societeID)->where('initier_livraison', 1)->count();
		$valideur_livraison = Profil::where('societe', $user->societeID)->where('valider_livraison', 1)->count();
		$gerer_livraison = Profil::where('societe', $user->societeID)->where('gerer_livraison', 1)->count();
		
		return view('societe/completerprofil', ['user' => $user, 'societe' => $myItem,
		'type_chantier_good' => $type_chantier_good,
		'type_livraisons_good' => $type_livraisons_good,
		'valideur_pieces' => $comptes_acc,
		'nombre_groupes' => $nombre_groupes,
		'comptes_acc' => $comptes_acc,
		'comptes_vg' => $comptes_vg,
		'pieces_oblig' => $myItem->choix_po,
		'habilitations' => $myItem->choix_hab,
		'valideur_intervenants' => $valideur_intervenants,
		'valideur_livraisons' => $valideur_livraison,
		'initier_chantiers' => $initier_chantiers,
		'initier_livraisons' => $initier_livraison,
		'gerer_livraisons' => $gerer_livraison,
		 'open' => 'parametres']);
    }
	
    public function chantiers()
    {
		$user = \Auth::user();
		
		$myItem = Societe::find($user->societeID);
		$chantiers = Chantier::where('do', $user->societeID)->where('categorie', 'virtuel')->limit(100)->get();
		
		return view('chantier/virtuels', ['user' => $user, 'societe' => $myItem, 'chantiers' => $chantiers, 'message' => '', 'sens' => 'Dossier émis', 'open' => 'chantier']);
    }
	
    public function show($message = "EMPTY")
    {
		$user = \Auth::user();
		
		$myItem = Societe::find($user->societeID);
		$lesPays = Pays::orderBy("libelle")->get();
		
        return view('societe/frm-change', ['user' => $user, 'lesPays' => $lesPays, 'societe' => $myItem, 'message' => $message, 'open' => 'societe']);
    }
	
    public function details($message = "EMPTY")
    {
		$user = \Auth::user();
		
		$myItem = Societe::find($user->societeID);
		$lesPays = Pays::orderBy("libelle")->get();
		
        return view('societe/frm-details', ['user' => $user, 'lesPays' => $lesPays, 'societe' => $myItem, 'message' => $message, 'open' => 'societe']);
    }
	
	/**** DOCUMENTS ****/
    public function documents($id, $message = "EMPTY")
    {
		setlocale(LC_ALL, 'fr_FR');
		$user = \Auth::user();
		
		$myItem = Societe::find($user->societeID);
		
		$documents = Document::where('societe', $user->societeID)->get();
		$liens = Lien::where('societe', $user->societeID)->get();
		
        return view('societe/documents', ['user' => $user, 'societe' => $myItem, 'liens' => $liens, 'documents' => $documents, 'message' => $message, 'open' => 'societe']);
    }
    
	public function upload(Request $request)
    {
		$user = \Auth::user();
        Storage::put("temp/".$request->input("data"), $request->file("file"));
    }
	
	public function seeDocument(Request $request)
	{
		$user = \Auth::user();
		$document = Document::find($request->input("id"));
		
		if(file_exists(public_path($document->chemin)))
		{
			$key = $document->chemin;
			copy(public_path($document->chemin), public_path("temp/".md5($key).".".$document->extension));
		}
		else
		{
			$key = $document->chemin;
			echo "Not copied : ".public_path($document->chemin);
		}
		
		return view('societe/visuel_document', ['user' => $user, 'document' => $document, 'key' => md5($key)]);
	}
		
	public function getDocument($id)
	{
		$user = \Auth::user();
		
		$document = Document::find($id);
		
		$headers = ['Content-Type' => 'application/pdf'];
		
		$myDirectory = "documents/".$user->societeID."/documents";

		return Storage::download($myDirectory.$document->chemin, 'doc.pdf', $headers);
	}
	
	/**** UTILISATEURS ****/
    public function habilitations($message = "EMPTY")
    {
		setlocale(LC_ALL, 'fr_FR');
		$user = \Auth::user();
		
		$myItem = Societe::find($user->societeID);
		
		$habilitations = Habilitation::where('societe', $user->societeID)->orWhere('oasis', 1)->get();
		$habilitation = new habilitation();
		
        return view('societe/habilitations', ['user' => $user, 'societe' => $myItem, 'habilitations' => $habilitations, 'habilitation' => $habilitation, 'new' => true, 'message' => $message, 'open' => 'societe']);
    }
    
	public function comptes($message = "EMPTY")
    {
		setlocale(LC_ALL, 'fr_FR');
		$user = \Auth::user();
		
		$myItem = Societe::find($user->societeID);
		
		$comptes = User::where('societeID', $user->societeID)->get();
		
        return view('societe/comptes', ['user' => $user, 'societe' => $myItem, 'comptes' => $comptes, 'message' => $message, 'open' => 'societe']);
    }
	
    public function creercompte($message = "EMPTY")
    {
		setlocale(LC_ALL, 'fr_FR');
		$user = \Auth::user();
		
		$myItem = Societe::find($user->societeID);
		
        return view('societe/ajoutercompte', ['user' => $user, 'societe' => $myItem, 'message' => $message, 'open' => 'societe']);
    }	
	
    public function ajoutercompte(Request $request)
    {
		setlocale(LC_ALL, 'fr_FR');
		$user = \Auth::user();

        $myItem = new User;
        $myItem->nom = $request->input("nom");
        $myItem->prenom = $request->input("prenom");
        $myItem->name = $request->input("nom")." ".$request->input("prenom");
        $myItem->email = $request->input("email");
        $myItem->fonction = $request->input("fonction");
        $myItem->password = Hash::make("Password*");
        $myItem->societeID = $user->societeID;
     
        $myItem->save();
		
		return $this->comptes();
    }
	
    public function compte($id, $message = "EMPTY")
    {
		setlocale(LC_ALL, 'fr_FR');
		$user = \Auth::user();
		
		$myItem = Societe::find($user->societeID);
		$compte = User::find($id);
		
        return view('societe/compte', ['user' => $user, 'societe' => $myItem, 'compte' => $compte, 'message' => $message, 'open' => 'societe']);
    }
	
    public function modifiercompte(Request $request)
    {
		setlocale(LC_ALL, 'fr_FR');
		$user = \Auth::user();

        $myItem = User::find($request->input("id"));
        
		if($myItem)
		{
			$myItem->nom = $request->input("nom");
	        $myItem->prenom = $request->input("prenom");
	        $myItem->name = $request->input("nom")." ".$request->input("prenom");
	        $myItem->email = $request->input("email");
	        $myItem->fonction = $request->input("fonction");
			
			$myItem->save();
		}
		else
		{
			
		}
        //$myItem->password = Hash::make("Password*");
        //$myItem->societeID = $user->societeID;
     	
		return $this->comptes();
    }
	
    public function deletecompte(Request $request)
    {
		setlocale(LC_ALL, 'fr_FR');
		$user = \Auth::user();

        $myItem = User::find($request->input("id"));
        $myItem->delete();
    }
	
	public function save(Request $request)
    {
		$user = \Auth::user();
		
        $this->validate($request, ['raisonSociale' => 'required']);

        $myItem = new Societe;
        $myItem->raisonSociale = $request->input("raisonSociale");
        $myItem->noSiret = $request->input("noSiret");
        $myItem->numeroTva = $request->input("numeroTva");
        $myItem->natureJuridique = $request->input("natureJuridique");
     
        $myItem->save();
		
		return $this->show($message = "ITEM_CHANGED");
    }
	
    public function change(Request $request)
    {
		$user = \Auth::user();
		
        $this->validate($request, ['raisonSociale' => 'required']);

        $myItem = Societe::find($request->input("id"));
        $myItem->raisonSociale = $request->input("raisonSociale");
        $myItem->noSiret = $request->input("noSiret");
        $myItem->tva = $request->input("TVA");
        $myItem->nom_usage = $request->input("nomUsage");
        $myItem->sigle = $request->input("sigle");
        $myItem->critere = $request->input("critere");
        $myItem->temporaire = $request->input("temporaire");
        $myItem->transport = $request->input("transport");
        $myItem->cerfi = $request->input("CERFI");
        $myItem->duns = $request->input("DUNS");
		
        $myItem->adresse = $request->input("adresse");
        $myItem->complement = $request->input("complement");
        $myItem->codePostal = $request->input("code_postal");
        $myItem->ville = $request->input("ville");
        
		// MODIFICATION DE LA ZONE DES INTERVENANTS DE L'ENTREPRISE
		if($myItem->pays <> $request->pays)
		{
			$newPays = Pays::find($request->pays);
			$affected = DB::table('entites')
					              ->where('societe', $myItem->id)
					              ->update(['zone_entreprise' => $newPays->zone]);
			
			$myItem->pays = $request->pays;
		}
		
        $myItem->telephone = $request->input("telephone");
		
        $myItem->responsableSecurite = $request->input("responsableSecurite");
        $myItem->chsct = $request->input("chsct");
        $myItem->medecinDuTravail = $request->input("medecinDuTravail");

        $myItem->nomDirecteur = $request->input("nomDirecteur");
        $myItem->prenomDirecteur = $request->input("prenomDirecteur");
        $myItem->titreDirecteur = $request->input("titreDirecteur");
        $myItem->email = $request->input("emailDirigeant");
		
		if($request->input("noSiret") == "")
        {
			$myItem->nomRepresentant = $request->input("nomRepresentant");
	        $myItem->prenomRepresentant = $request->input("prenomRepresentant");
	        $myItem->fonctionRepresentant = $request->input("fonctionRepresentant");
	        $myItem->telephoneRepresentant = $request->input("telephoneRepresentant");
        }
     
        $myItem->save();
    }
	
    public function chargerdocument(Request $request)
    {
		$user = \Auth::user();
		
       	$myItem = Societe::find($request->input("id"));

		// ON VERIFIE QU'ON A PAS DEJA UNE PIECE DE CE TYPE EN BASE
		if ($request->hasFile('fichier'))
		{
			if(Document::where('type_piece', $request->input("type_piece"))->where('societe', $request->input("id"))->doesntExist())
			{
				// DO NOTHING
			}
			else
			{
				$document = Document::where('type_piece', $request->input("type_piece"))->where('societe', $request->input("id"))->first();
				$document->delete();
			}
			
			$name = $request->fichier->getClientOriginalName();
			$error = $request->fichier->move("documents/".$user->societeID, $name);

			$myPiece = new Document;
			$myPiece->chemin = "documents/".$user->societeID."/".$name;
			$myPiece->extension = $request->fichier->getClientOriginalExtension();
	        $myPiece->societe = $user->societeID;
	        $myPiece->type_piece = $request->input("type_piece");
	        $myPiece->date_expiration = $request->input("date_expiration");
	        $myPiece->nom = $request->input("nom");
 
	        $myPiece->save();
		}
	
		return $this->documents($user->societeID);
    }
	
    public function deletedocument(Request $request)
    {
		$user = \Auth::user();
		
       	$myDocument = Document::find($request->input("id"));
		$myDocument->delete();
     
        return "";
    }
	
    public function delete($id)
    {
		$user = \Auth::user();
		
       	$myItem = Entite::find($id);

        $myItem->statut = 'deleted';
     
        $myItem->save();
		
		return $this->intervenants();
    }
	
    public function lister($message = "EMPTY")
    {
		$user = \Auth::user();
		
		$societes = Societe::where('deleted', 0)->get();
		
        return view('societe/lister', ['user' => $user, 'societes' => $societes, 'open' => 'societe', 'message' => $message]);
    }
	
    public function fiche($id, $message = "EMPTY")
    {
		$user = \Auth::user();
		
		$myItem = Societe::find($id);
		$documents = Document::where('societe', $id)->get();
		$liens = Lien::where('societe', $id)->get();
		
		if($user->groupe ==  "admin")
        	return view('societe/fiche-admin', ['user' => $user, 'societe' => $myItem, 'liens' => $liens, 'documents' => $documents, 'open' => 'societe', 'message' => $message]);
		else
			return view('societe/fiche', ['user' => $user, 'societe' => $myItem, 'liens' => $liens, 'documents' => $documents, 'open' => 'societe', 'message' => $message]);
    }
	
    public function addacces(Request $request)
    {
		$user = \Auth::user();
		
       	$myItem = Societe::find($request->input("id"));

		// ON VERIFIE QU'ON A PAS DEJA UNE PIECE DE CE TYPE EN BASE
		
		$myLink = new Lien;
        $myLink->societe = $request->input("id");
        $myLink->login = $request->input("email");
        $myLink->contact = $request->input("contact");
        $myLink->url = "1234".date("dYs");
        $myLink->date_expiration = $request->input("date_expiration");
 
        $myLink->save();
			
		$liens = Lien::where('societe', $request->input("id"))->get();
		
        return view('societe/accestiers', ['user' => $user, 'societe' => $myItem, 'open' => 'societe', 'liens' => $liens]);
	}
	
    public function deletelink(Request $request)
    {
		$user = \Auth::user();
		
       	$myItem = Lien::find($request->input("id"));
		$myItem->delete();
		
		return "OK";
    }
	
	public function sendlink(Request $request)
    {
		$user = \Auth::user();
		
       	$myItem = Lien::find($request->input("id"));
		//$myItem->delete();
		
		return '<i class="fa fa-2x fa-check-circle text-success"></i>';
    }
	
    public function getinfo(Request $request)
    {
		$user = \Auth::user();
		
       	$myItem = Societe::find($request->input("societe_ID"));
		switch($request->input("field"))
		{
			default :
				$field = $request->input("field");
				$res = $myItem->$field;
				return $res;
				break;
			case "interim" :
				$field = $request->input("field");
				$res = $myItem->$field;
				if($myItem->temporaire)
				{
					return '
					<label>Agence intérim</label>
					<div class="kt-radio-inline">
						<label class="kt-radio">
							<input type="radio" checked name="interim" value="1"> Oui
							<span></span>
						</label>
						<label class="kt-radio">
							<input type="radio" name="interim" value="0"> Non
							<span></span>
						</label>
					</div>';
				}
				else
				{
					return '
					<label>Agence intérim</label>
					<div class="kt-radio-inline">
						<label class="kt-radio">
							<input type="radio" name="interim" value="1"> Oui
							<span></span>
						</label>
						<label class="kt-radio">
							<input type="radio" checked name="interim" value="0"> Non
							<span></span>
						</label>
					</div>';
				}
				break;
		}
    }
}