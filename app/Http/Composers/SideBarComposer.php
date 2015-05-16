<?php
/**
 * Created by PhpStorm.
 * User: Dagnis
 * Date: 16.05.2015.
 * Time: 13:52
 */

namespace App\Http\Composers;

use Illuminate\Contracts\View\View;
use App\Winner;

class SideBarComposer {

    /**
    * Admin paneļa submenu konkursu navigācijas izsaukšana vienmēr
    * @param View $view
    */
    public function main(View $view){
        $winners = Winner::orderBy('created_at', 'DESC')
            ->take(5)
            ->get();
        $view->with(compact('winners'));
    }
} 