<?php

namespace App\Http\Controllers;


use App\User;
use App\Chantier;
use App\Copie;
use App\Notification;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class NotificationController extends Controller
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
		
		$notifications = Notification::where('prestataire', $user->societeID)->where('status', 'unread')->get();
		$notifications_lues = Notification::where('prestataire', $user->societeID)->where('status', 'read')->get();
		
		return view('notification/notifications', ['user' => $user, 'notifications' => $notifications, 'notifications_lues' => $notifications_lues]);
    }
	
    public function show($id)
    {
		$user = \Auth::user();
		
		$notification = Notification::find($id);
		$notification->status = "read";
		$notification->save();
			
		return redirect('/chantier/intervenants/'.$notification->chantier);
    }
}
