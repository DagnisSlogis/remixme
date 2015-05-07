<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Notification;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;

class NotificationController extends Controller {

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
    public function index(Notification $notification)
    {
        $notifications = $notification->whereUserId(Auth::user()->id)
            ->where('show_date', '<=', Carbon::now())
            ->orWhere('show_date', '=', NULL)
            ->orderBy('created_at', 'desc')
            ->orderBy('show_date', 'asc')
            ->paginate(10);
        return view('userpanel.notification' , compact('notifications'));
    }

}
