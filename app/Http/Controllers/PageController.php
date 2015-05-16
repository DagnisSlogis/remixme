<?php namespace App\Http\Controllers;

use App\Comment;
use App\Comp;
use App\Http\Requests;
use App\Submition;
use App\Winner;
use Auth;
use App\Http\Controllers\Controller;

use Carbon\Carbon;
use Illuminate\Http\Request;

class PageController extends Controller {

    /**
     * Pieejas liegšana dažādam lietotāja grupām kontroliera funkcijām
     *
     */
    public function __construct()
    {
        $this->middleware('auth' , [ 'except' => 'WinnerPage']);
        $this->middleware('admin' , [ 'only' => 'AdminPanel']);
    }

    /**
     * Administratora paneļa izsaukšana
     * @return \Illuminate\View\View
     */
    public function AdminPanel()
    {
        return view('adminpanel.index');
    }

    /**
     * Lietotāja paneļa izsaukšana
     * @return \Illuminate\View\View
     */
    public function UserPanel()
    {
        $CompCount = Comp::whereUserId(Auth::user()->id)
            ->whereStatus('v')
            ->count();
        $WinnerCount = Winner::join('votings', 'winners.voting_id', '=', 'votings.id')
            ->join('comps' , 'votings.comp_id' ,'=', 'comps.id')
            ->count('winners.id');
        $YourComment = Comment::whereUserId(Auth::user()->id)
            ->whereStatus('v')
            ->count();
        $YourSubmitions = Submition::whereUserId(Auth::user()->id)
            ->whereStatus('v')
            ->count();
        return view('userpanel/index' , compact('CompCount' , 'WinnerCount' , 'YourComment' , 'YourSubmitions'));
    }
    public function WinnerPage()
    {
        $comps = Comp::where('comp_end_date' , '<=' , Carbon::now())
            ->whereHas('voting', function($q)
            {
                $q->where('status', 'b');
            })
            ->paginate(5);
        return view('pages.winner', compact('comps'));
    }
}
