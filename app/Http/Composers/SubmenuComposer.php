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
     * Admin paneļa konkursa submenu navigācijas datu ielase
     *
     * @param View $view
     */
    public function comppanel(View $view){
        $unacceptedCount =  Comp::whereStatus('a')
            ->where('comp_end_date', '>=' , Carbon::now())
            ->count();
        $runningsCount = Comp::whereNotIn('status' , array('b' , 'a'))
            ->where('comp_end_date', '>=' , Carbon::now())->count();
        $view->with(compact('unacceptedCount' , 'runningsCount' , 'compsCount'));
    }
} 