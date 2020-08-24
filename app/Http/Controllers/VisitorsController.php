<?php

namespace App\Http\Controllers;

use App\Action;
use App\ChantierDo;
use App\EquipierDo;
use App\Justificatif;
use App\Societe;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use League\Flysystem\FileNotFoundException;
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class VisitorsController extends Controller
{
   	public function index($societeID = 0)
    {
		try
		{
			$societe = ($societeID <> 0) ? Societe::find($societeID) : new Societe();
			$users = User::where('email', '=', $societe->email)->get();
		
			if(sizeof($users) > 0)
				return view('register', ['societe' => $societe]);
				//return view('error', ['message' => "Un compte avec cet identifiant existe déjà dans nos base."]);
			else
				return view('register', ['societe' => $societe]);
			
		} catch (\Exception $e) {
			return view('error', ['message' => "Le lien que vous essayez d'atteindre n'existe pas ou a expiré."]);
		}
    }
	
   	public function index2($societeID = 0)
    {
		try
		{
			$societe = ($societeID <> 0) ? Societe::find($societeID) : new Societe();
			$users = User::where('email', '=', $societe->email)->get();
		
			if(sizeof($users) > 0)
				return view('register2', ['societe' => $societe]);
				//return view('error', ['message' => "Un compte avec cet identifiant existe déjà dans nos base."]);
			else
				return view('register2', ['societe' => $societe]);
			
		} catch (\Exception $e) {
			return view('error', ['message' => "Le lien que vous essayez d'atteindre n'existe pas ou a expiré."]);
		}
    }
	
    public function verifierpassword(Request $request)
    {
		$password = $request->input("password");
		
		if (preg_match('#^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]){2}(?=.*\W).{8,}$#', $password))
			return '';
		else
			return 'Votre mot de passe doit contenir au minimum deux chiffres';
    }
	
    public function createuser(Request $request)
    {
		if(!$request->input("cgu"))
		{
			abort(403, 'Veuillez accepter les CGU');
		}
		
		if(!$request->input("rgpd"))
		{
			abort(403, 'Veuillez accepter les conditions RGPD');
		}
		
		// SI LA SOCIETE EST A 0 ON VA LA CREER SINON ON LA MET A JOUR
		if($request->input("societe") == 0)
		{
			$mySociety = new Societe();
			$mySociety->raisonSociale = $request->input("raison_sociale");
			$mySociety->noSiret = $request->input("no_siret");
			
			$mySociety->nom_usage = $request->input("nom_usage");
			$mySociety->sigle = $request->input("sigle");
			$mySociety->critere = $request->input("critere");
			
			$mySociety->temporaire = $request->input("temporaire");
			$mySociety->transport = $request->input("transport");

			$mySociety->cerfi = $request->input("CERFI");
			$mySociety->duns = $request->input("DUNS");
			$mySociety->tva = $request->input("TVA");

			$mySociety->adresse = $request->input("adresse");
			$mySociety->complement = $request->input("complement");
			$mySociety->codePostal = $request->input("code_postal");
			$mySociety->ville = $request->input("ville");
			$mySociety->pays = $request->input("pays");
			
			$mySociety->telephone = $request->input("telephone");
			
			$mySociety->nomDirecteur = $request->input("nomDirecteur");
			$mySociety->prenomDirecteur = $request->input("prenomDirecteur");
			$mySociety->titreDirecteur = $request->input("titreDirecteur");
			
			$mySociety->nomRepresentant = $request->input("nomRepresentant");
			$mySociety->prenomRepresentant = $request->input("prenomRepresentant");
			$mySociety->fonctionRepresentant = $request->input("fonctionRepresentant");
			$mySociety->telephoneRepresentant = $request->input("telephoneRepresentant");
			
			$mySociety->save();
		}
		else
		{
			$mySociety = Societe::find($request->input("societe"));
			
			$mySociety->raisonSociale = $request->input("raison_sociale");
			$mySociety->noSiret = $request->input("no_siret");
			$mySociety->nom_usage = $request->input("nom_usage");
			$mySociety->sigle = $request->input("sigle");
			$mySociety->critere = $request->input("critere");
			
			$mySociety->temporaire = $request->input("temporaire");
			$mySociety->transport = $request->input("transport");

			$mySociety->cerfi = $request->input("CERFI");
			$mySociety->duns = $request->input("DUNS");
			$mySociety->tva = $request->input("TVA");

			$mySociety->adresse = $request->input("adresse");
			$mySociety->complement = $request->input("complement");
			$mySociety->codePostal = $request->input("code_postal");
			$mySociety->ville = $request->input("ville");
			$mySociety->pays = $request->input("pays");
			
			$mySociety->telephone = $request->input("telephone");
			
			$mySociety->nomDirecteur = $request->input("nomDirecteur");
			$mySociety->prenomDirecteur = $request->input("prenomDirecteur");
			$mySociety->titreDirecteur = $request->input("titreDirecteur");
			
			$mySociety->nomRepresentant = $request->input("nomRepresentant");
			$mySociety->prenomRepresentant = $request->input("prenomRepresentant");
			$mySociety->fonctionRepresentant = $request->input("fonctionRepresentant");
			$mySociety->telephoneRepresentant = $request->input("telephoneRepresentant");
			
			$mySociety->save();
		}
		
		$myItem = new User;
        $myItem->name = trim($request->input("nomUser")." ".$request->input("prenomUser"));
        $myItem->nom = $request->input("nomUser");
        $myItem->prenom = $request->input("prenomUser");
        $myItem->fonction = $request->input("fonctionUser");
        $myItem->telephone = $request->input("telephoneUser");
        $myItem->email = $request->input("identifiant");
        $myItem->do = 0;
        $myItem->groupe = 'user';
        $myItem->societeID = $mySociety->id;
		
		$mypass = $request->input("password");
        $myItem->password = Hash::make($mypass);
        $myItem->fonction = $mypass;
 
    	$myItem->save();
    }
	
    public function rechercherpresta(Request $request)
    {
		$prestataires = Societe::where('deleted', 0)->where('active', 0)->where('raisonSociale', 'like', '%'.$request->input("keywords").'%')->get();
		
		if(sizeof($prestataires) > 0)
			return '<i class="fa fa-exclamation-triangle"></i> Une société avec la même raison sociale existe déjà';
		else
			return 'Indiquez ici la raison sociale telle qu\'elle apparait sur le Kbis.';
    }
	
    public function rechercherpresta2(Request $request)
    {
		$users = User::where('email', '=', $request->input("keywords"))->get();
		
		if(sizeof($users) > 0)
			return '<i class="fa fa-exclamation-triangle"></i> Cette adresse est déjà utilisée dans nos bases, veuillez utiliser la procédure de mot de passe oublié pour accéder au compte';
		else
			return '';
    }
	
    public function rechercherpresta3(Request $request)
    {
		$clean = str_replace("_", "", $request->input("keywords"));
		if(strlen($clean) < 17)
			return '<i class="fa fa-exclamation-triangle"></i> Veuillez saisir un numéro valide.';
		
		$siret = Societe::where('deleted', 0)->where('active', 0)->where('noSiret', '=', $clean)->get();
		
		if(sizeof($siret) > 0)
			return '<i class="fa fa-exclamation-triangle"></i> Un compte avec ce SIRET existe déjà sur OASIS, renseignez-vous dans votre entreprise ou contacter notre support !';
		else
		{
			$siret = Societe::where('deleted', 0)->where('active', 0)->where('noSiret', 'like', substr($clean, 0, 9).'%')->get();
			if(sizeof($siret) > 0)
				return 'warning';
			else
				return '';
		}	
    }
	
	public function showDoGuest($url)
	{
		$intervenant = EquipierDo::where('accesskey', $url)->first();
		$chantier = ChantierDo::find($intervenant->chantier);
		$intervenants = EquipierDo::where('chantier', $intervenant->chantier)->first();
	
        return view('chantier/changedoGuest', ['chantier' => $chantier, 'intervenant' => $intervenant, 'open' => 'chantier']);
	}
	
	public function actionGuest($id)
	{
		$action = Action::find($id);
		
		$intervenant = EquipierDo::where('id', $action->qui)->first();
		$chantier = ChantierDo::find($intervenant->chantier);
		$intervenants = EquipierDo::where('chantier', $intervenant->chantier)->first();
		$documents = Justificatif::where('action', $id)->get();
	
        return view('chantier/actionGuest', ['chantier' => $chantier, 'action' => $action, 'documents' => $documents, 'intervenant' => $intervenant, 'url' => $intervenant->acceskey, 'open' => 'chantier']);
	}
	
	public function actionValidateGuest($id)
	{
		$action = Action::find($id);
	
		$intervenant = EquipierDo::where('id', $action->validation)->first();
		$chantier = ChantierDo::find($intervenant->chantier);
		$intervenants = EquipierDo::where('chantier', $intervenant->chantier)->first();
		$documents = Justificatif::where('action', $id)->get();

        return view('chantier/actionGuest', ['chantier' => $chantier, 'action' => $action, 'documents' => $documents, 'intervenant' => $intervenant, 'url' => $intervenant->acceskey, 'open' => 'chantier']);
	}
	
	public function accesaction($url)
	{
		$intervenant = EquipierDo::where('accesskey', $url)->first();
		$myItem = ChantierDo::find($intervenant->chantier);
		$actions = Action::where('chantier', $intervenant->chantier)->get();
		$intervenants = EquipierDo::where('chantier', $intervenant->chantier)->first();
	
        return view('chantier/actionsDoGuest', ['intervenants' => $intervenants, 'intervenant' => $intervenant, 'url' => $url, 'actions' => $actions, 'chantier' => $myItem, 'open' => 'chantier']);
	}
	
	public function saveaction(Request $request)
    {
		$action = Action::find($request->input("action"));
		$action->description = $request->input("description");
		if($action->validation <> 0)
		{
			$action->statut = "a valider";
			// TODO NOTIFIER VALIDEUR
		}	
		$action->save();
		
		return $this->actionGuest($request->input("action"));
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
			
			return $this->actionGuest($request->input("action"));
		}
		else
		{
			// DO NOTHING FOR NOW
			return $this->actionGuest($request->input("action"), "ERROR_MISSING");
		}
	}
	
	public function downloadJustificatif($id, Response $response)
	{
		$justificatif = Justificatif::find($id);
		
		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.basename($justificatif->chemin));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		header('Content-Length: ' . filesize($justificatif->chemin));
		ob_clean();
		flush();
		readfile($justificatif->chemin);
	}
	
	public function terminer(Request $request)
    {
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
}
