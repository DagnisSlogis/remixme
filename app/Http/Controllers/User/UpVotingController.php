<?php namespace App\Http\Controllers\User;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Voting;

class UpVotingController extends Controller {

	public function index()
    {
        $judgings = Voting::join('comps', 'votings.comp_id', '=', 'comps.id')
            ->where('comps.voting_type','=' , 'z')
            ->where('votings.show_date', '<=' , Carbon::now())
            ->where('votings.status' , '=' , 'v')
            ->select('comps.*')
            ->paginate(10);
        return view('userpanel.comps.judging' , compact('judgings'));
    }


}
