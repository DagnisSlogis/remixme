<?php
/**
 * Created by PhpStorm.
 * User: Dagnis
 * Date: 10.05.2015.
 * Time: 15:06
 */

namespace App\Http\Composers;
use App\Voting;
use Auth;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class CompSubmenuComposer {

    /**
     * Ielasa datus priekš lietotājpaneļa konkursu sub navigācijas
     *
     * @param View $view
     */
    public function main(View $view){
        $judging = Voting::join('comps', 'votings.comp_id', '=', 'comps.id')
            ->where('comps.voting_type','=' , 'z')
            ->where('comps.user_id' , Auth::user()->id)
            ->where('votings.show_date', '<=' , Carbon::now())
            ->where('votings.status', '=' , 'v')
            ->count();
        $voting = Voting::join('comps', 'votings.comp_id', '=', 'comps.id')
            ->where('comps.voting_type','=' , 'b')
            ->where('comps.user_id' , Auth::user()->id)
            ->where('votings.status', '=' , 'v')
            ->where('votings.show_date', '<=' , Carbon::now())
            ->count();
        $view->with(compact('judging' , 'voting'));
    }
} 