<?php

namespace App\Http\Controllers;


use App\User;
use App\Chantier;
use App\Notification;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class HomeController extends Controller
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
		$user = \Auth::user();
		
		switch($user->groupe)
		{
			default :
				$chantier = Chantier::find(1);
				
				// ON RECUPERE LES NOTIFICATIONS DE LA SOCIETE
				$notifications = Notification::where('prestataire', $user->societeID)->where('status', 'unread')->limit(5)->get();
				
				if($user->do == 1)
					$chantiers = Chantier::where('do', $user->societeID)->limit(20)->get();
				else
					$chantiers = Chantier::where('societe', $user->societeID)->limit(20)->get();
				
				$pieces = array();
				
				$message = "";
				
				return view('home', ['user' => $user, 'chantiers' => $chantiers, 'message' => $message, 'notifications' => $notifications, 'pieces' => $pieces]);
				break;
			case "admin" : 
				return view('dashboard', ['user' => $user]);
				break;
		}
    }
}
