<?php namespace App\Http\Controllers;

use App\Comp;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Submition;
use App\Vote;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VotingController extends Controller {

    /**
     * Pieejas liegšana viesiem
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     *  Izveido skatu ar jaunākajām balsošanām
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $comps = Comp::where('comp_end_date','>=', Carbon::now())
            ->where('subm_end_date','<=', Carbon::now())
            ->where('voting_type','=' , 'b')
            ->whereHas('submitions', function($q)
            {
                $q->where('status', 'v');

            })->whereHas('voting', function($q)
            {
                $q->where('status', 'v');

            })->orderBy('subm_end_date' , 'desc')
            ->paginate(5);
        return view('pages.voting' , compact('comps'));
    }


    /**
     * Izveido skatu ar balsošanām, kuras drīz beigsies
     *
     * @return \Illuminate\View\View
     */
    public function soonEnds()
    {
        $comps = Comp::where('comp_end_date','>=', Carbon::now())
            ->where('subm_end_date','<=', Carbon::now())
            ->where('voting_type','=' , 'b')
            ->whereHas('submitions', function($q)
            {
                $q->where('status', 'v');

            })->whereHas('voting', function($q)
            {
                $q->where('status', 'v');

            })->orderBy('comp_end_date' , 'asc')
            ->paginate(5);
        return view('pages.voting' , compact('comps'));
    }

    /**
     * Izveido skatu ar populārākajām balsošanām
     *
     * @return \Illuminate\View\View
     */
    public function popular()
    {
        $comps = Comp::select(
            '*',
            DB::raw("(SELECT COUNT(*) FROM `submitions` WHERE `comp_id` = `comps`.`id`) AS 'count'")
        )
            ->where('comp_end_date','>=', Carbon::now())
            ->where('subm_end_date','<=', Carbon::now())
            ->where('voting_type','=' , 'b')
            ->whereHas('submitions', function($q)
            {
                $q->where('status', 'v');

            })->whereHas('voting', function($q)
            {
                $q->where('status', 'v');

            })->whereStatus('v')
            ->orderBy('count', 'desc')
            ->paginate(5);
        return view('pages.voting' , compact('comps'));
    }

    /**
     * Balsošana par dziesmu
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id)
    {
        $submition = Submition::whereId($id)->first();
        $comp = Comp::whereId($submition->comp_id)->first();
        $check = Vote::whereSubmitionId($submition->id)->whereUserId(Auth::user()->id)->first();
        if($check)
        {
            \Session::flash('error_message', 'Jūs jau esat balsojis par šo dziesmu');
            return redirect()->back();
        }
        elseif($comp->comp_end_date <= Carbon::now())
        {
            \Session::flash('error_message', 'Balsošana ir beigusies');
            return redirect()->back();
        }
        else
        {
            $submition->votes = $submition->votes+1;
            $submition->save();
            $vote = new Vote;
            $vote->user_id = Auth::user()->id;
            $vote->submition_id = $submition->id;
            $vote->save();
            \Session::flash('success_message', 'Jūs veiksmīgi esat nobalsojis par dziesmu');
            return redirect()->back();
        }
    }

    /**
     * Balsošanas pilnskats, parāda visus balsojamos konkursus.
     *
     * @param $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $comp = Comp::whereId($id)->first();
        return view('pages.showvoting' ,  compact('comp'));
    }

    /**
     * Meklēt balsošanu
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function find(Request $request)
    {
        $comps = Comp::where('comp_end_date','>', Carbon::now())
            ->where('subm_end_date','<=', Carbon::now())
            ->where('voting_type','=' , 'b')
            ->where('status', 'v')
            ->whereNested(function($query)use($request)
            {
                    $query->where('title', 'LIKE', '%'. $request->get('s') .'%')
                        ->orWhere('genre', 'LIKE', '%'. $request->get('s') .'%')
                        ->orWhere('song_title', 'LIKE', '%'. $request->get('s') .'%');
            })->orderBy('subm_end_date' , 'desc')
            ->paginate(5);
        return view('pages.voting' , compact('comps'));
    }


}
