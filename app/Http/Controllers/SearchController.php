<?php

namespace App\Http\Controllers;


use App\User;
use App\Chantier;
use App\Copie;
use App\Notification;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class SearchController extends Controller
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
    public function index(Request $request)
    {
		$user = \Auth::user();
		
		$results = Chantier::where('do', $user->societeID)
			->where('libelle', 'like', '%'.$request->input("keywords").'%')
			->orWhere('numero', 'like', '%'.$request->input("keywords").'%')
			->get();
		
		$keywords = $request->input("keywords");
		$request->session()->put('keywords', $keywords);
		
		return view('search', ['user' => $user, 'results' => $results, 'keywords' => $keywords]);
    }
	
    public function results(Request $request)
    {
		$user = \Auth::user();
		$keywords = $request->session()->get('keywords');
		
		if($keywords != "")
		{
			$results = Chantier::where('do', $user->societeID)->offset(($request->pagination["page"]-1)*$request->pagination["perpage"])->limit($request->pagination["perpage"])->where('numero', 'like', '%'.$keywords.'%')->get();
			$results_all = Chantier::where('do', $user->societeID)->where('numero', 'like', '%'.$keywords.'%')->get();
		}	
		else
		{
			$results = Chantier::where('do', $user->societeID)->offset(($request->pagination["page"]-1)*$request->pagination["perpage"])->limit($request->pagination["perpage"])->get();
			$results_all = Chantier::where('do', $user->societeID)->get();
		}
			
		
		$meta = array();
		$meta["page"] = $request->pagination["page"];
		$meta["pages"] = count($results_all);
		$meta["perpage"] = $request->pagination["perpage"];
		$meta["total"] = count($results_all);
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
			$chantier["Prestataire"] = $myChantier->titulaire_s();
			$chantier["Date"] = date('d/m/Y', strtotime($myChantier->date_debut));
			$chantier["Statut"] = $myChantier->statut();
			$chantier["state"] = "";
			$chantier["Actions"] = "";
			
			$data[] = $chantier;
		}
		
		$response["data"] = $data;
		
		return json_encode($response);
    }
}
