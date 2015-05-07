<?php namespace App\Http\Composers;
use App\Comp;
use App\Notification;
use Auth;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
/**
 * Created by PhpStorm.
 * User: Dagnis
 * Date: 28.04.2015.
 * Time: 14:02
 */
class NotificationComposer {

    /**
     * Padod atgādinājumu iznirstošajam pogam datus
     * @param View $view
     */
    public function main(View $view ){
        if(Auth::user())
        {
            $notifications = Notification::whereUserId(Auth::user()->id)
                ->where('show_date', '<=', Carbon::now())
                ->orWhere('show_date', '=', NULL)
                ->where('is_read', '=' , '0')
                ->with('comp')
                ->orderBy('created_at', 'desc')
                ->get();
        }
        $view->with(compact('notifications'));
    }
}