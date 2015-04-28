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
        $unacceptedCount =  count(Comp::whereStatus('a')
            ->where('comp_end_date', '>=' , Carbon::now())
            ->get());
        $runningsCount = count(Comp::whereNotIn('status' , array('d' , 'a'))
            ->where('comp_end_date', '>=' , Carbon::now())->get());
        $compsCount =  count(Comp::whereNotIn('status' , array('d' , 'a'))->get());
        $view->with(compact('unacceptedCount' , 'runningsCount' , 'compsCount'));
    }
} 