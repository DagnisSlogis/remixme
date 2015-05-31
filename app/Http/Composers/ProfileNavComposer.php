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
     * Ielasa lietotāja paziņojumu skaitu, un administratoram neapstiprinātos konkursus
     *
     * @param View $view
     */
    public function main(View $view ){
        if(Auth::user())
        {
            $unacceptedComps = Comp::whereStatus('a')
                ->where('comp_end_date', '>=', Carbon::now())
                ->count();
            $simpleNotif = Notification::whereUserId(Auth::user()->id)
                ->whereIsRead(0)
                ->where('show_date', NULL)
                ->count();
            $lateNotif = Notification::whereUserId(Auth::user()->id)
                ->whereIsRead(0)
                ->where('show_date', '<=', Carbon::now())
                ->count();
            $notifCount = $simpleNotif + $lateNotif;
        }
        $view->with(compact('unacceptedComps' , 'notifCount'));
    }
}