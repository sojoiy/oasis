<?php

namespace App\Http\Controllers;

use App\Profil;
use App\Service;
use App\Habilitation;
use App\Societe;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
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
	
    public function account($message = "EMPTY")
    {
		$user = \Auth::user();
		
		$services = Service::where('societe', $user->societeID)->where('deleted', NULL)->get();
		$profils = Profil::where('societe', $user->societeID)->where('deleted', NULL)->get();
		
        return view('account', ['user' => $user, 'compte' => $user, 'message' => $message, 'services' => $services, 'profils' => $profils]);
    }
	
    public function change(Request $request)
    {
		$user = \Auth::user();
		
		try {
	        $myItem = User::find($request->input("id"));
	        $myItem->name = trim($request->input("nom")." ".$request->input("prenom"));
	        $myItem->nom = $request->input("nom");
	        $myItem->prenom = $request->input("prenom");
	        $myItem->telephone = $request->input("telephone");
	        $myItem->email = $request->input("email");
     
        	$myItem->save();
			
			return $this->account("OK");
		} catch (\Exception $e) {
			return $this->account("ALREADY_EXISTS");
	    }
    }
	
    public function resetpassword(Request $request)
    {
		$user = \Auth::user();
		
		try {
	        $user->password = Hash::make('Password*');
     
        	$user->save();
		} catch (\Exception $e) {
			return $this->account("ALREADY_EXISTS");
	    }
    }
	
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function register()
    {
        return view('register');
    }
}
