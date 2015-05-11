<?php namespace App\Http\Composers;
use App\Comp;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;

/**
 * Created by PhpStorm.
 * User: Dagnis
 * Date: 21.04.2015.
 * Time: 11:27
 */

class SubmenuComposer {

    /**
     * Admin paneļa submenu konkursu navigācijas izsaukšana vienmēr
     * @param View $view
     */
    public function comppanel(View $view){
        $unacceptedCount =  Comp::whereStatus('a')
            ->where('comp_end_date', '>=' , Carbon::now())
            ->count();
        $runningsCount = Comp::whereNotIn('status' , array('d' , 'a'))
            ->where('comp_end_date', '>=' , Carbon::now())->count();
        $compsCount =  Comp::whereNotIn('status' , array('d' , 'a'))->count();
        $view->with(compact('unacceptedCount' , 'runningsCount' , 'compsCount'));
    }
} 