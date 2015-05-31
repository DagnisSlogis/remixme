<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Notification;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;

class NotificationController extends Controller {

    /**
     * Pieejas liegšana viesiem
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Tiek iegūti dati no ajax pieprasījuma, lai atzīmētu jaunos paziņojumus kā izlasītus
     *
     * @param Notification $notif
     */
    public function  set_as_read(Notification $notif)
    {
        $IsRead = Input::get('IsRead');
        $i = count($IsRead)-1;
        while ($i != -1)
        {
            $read = $notif->whereId($IsRead[$i])->first();
            $read->is_read = 1;
            $read->save();
            $i--;
        }

    }

    /**
     * Parāda lietotāja paziņojumus
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $notifications = Notification::whereNested(function($query)
        {
            $query->where('show_date', '=', NULL)
                ->orWhere('show_date', '<=', Carbon::now());
        })
            ->whereUserId(Auth::user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('userpanel.notification' , compact('notifications'));
    }

}
