<?php namespace App\Http\Controllers;

use App\Comp;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Votable;
use App\Vote;
use Carbon\Carbon;
use Illuminate\Http\Request;

class VotingController extends Controller {

	public function index()
    {
        $comps = Comp::where('comp_end_date','>=', Carbon::now())
            ->where('comps.voting_type','=' , 'b')
            ->whereHas('voting', function($q)
            {
                $q->where('status', 'v');

            })
            ->whereHas('submitions', function($q)
            {
                $q->where('status', 'v');

            })->paginate(5);
        return view('pages.voting' , compact('comps'));
    }

    public function update($id)
    {
        $votable = Votable::whereSubmitionId($id)->first();
        $check = Vote::whereVotableId($votable->id)->whereUserId(Auth::user()->id)->first();
        if($check) {
            \Session::flash('error_message', 'Jūs jau esat balsojis par šo dziesmu');
            return redirect()->back();
        }
        else
        {
            $votable->votes = $votable->votes+1;
            $votable->save();
            $vote = new Vote;
            $vote->user_id = Auth::user()->id;
            $vote->votable_id = $votable->id;
            $vote->save();
            \Session::flash('success_message', 'Jūs veiksmīgi esat nobalsojis par dziesmu');
            return redirect()->back();
        }

    }
    public function show($id)
    {
        $comp = Comp::whereId($id)->first();

        return view('pages.showvoting' ,  compact('comp'));
    }


}
