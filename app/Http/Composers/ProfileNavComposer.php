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
 * Time: 10:13
 */
class ProfileNavComposer {

    /**
     * Admin paneļa submenu konkursu navigācijas izsaukšana vienmēr
     * @param View $view
     */
    public function main(View $view ){
        if(Auth::user())
        {
            $unacceptedComps = count(Comp::whereStatus('a')
                ->where('comp_end_date', '>=', Carbon::now())
                ->get());
            $simpleNotif = count(Notification::whereUserId(Auth::user()->id)
                ->whereIsRead(0)
                ->whereShowDate(NULL)
                ->get());
            $lateNotif = count(Notification::whereUserId(Auth::user()->id)
                ->whereIsRead(0)
                ->where('show_date', '<=', Carbon::now())
                ->get());
            $notifCount = $simpleNotif + $lateNotif;
        }
        $view->with(compact('unacceptedComps' , 'notifCount'));
    }
}