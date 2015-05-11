<?php
/**
 * Created by PhpStorm.
 * User: Dagnis
 * Date: 10.05.2015.
 * Time: 15:06
 */

namespace App\Http\Composers;
use App\Voting;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class CompSubmenuComposer {
    public function main(View $view){
        $judging = Voting::join('comps', 'votings.comp_id', '=', 'comps.id')
            ->where('comps.voting_type','=' , 'z')
            ->where('votings.show_date', '<=' , Carbon::now())
            ->where('votings.status', '=' , 'v')
            ->count();
        $view->with(compact('judging'));
    }
} 