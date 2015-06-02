<?php namespace App\Http\Controllers;

use App\Comment;
use App\Comp;
use App\Http\Requests;
use App\Submition;
use App\Winner;
use Auth;
use App\Http\Controllers\Admin\ApCompController as ApComp;
use App\Http\Controllers\Admin\ApUserController as ApUser;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PageController extends Controller {

    /**
     * Pieejas liegšana dažādam lietotāja grupām kontroliera funkcijām
     *
     */
    public function __construct()
    {
        $this->middleware('auth' );
        $this->middleware('admin' , [ 'only' => 'AdminPanel']);
    }

    /**
     * Administratora paneļa izsaukšana
     *
     * @return \Illuminate\View\View
     */
    public function AdminPanel()
    {
        $CompCount = Comp::whereStatus('v')
            ->count();
        $WinnerCount = Winner::count();
        $AllComment = Comment::whereStatus('v')
            ->count();
        $AllSubmitions = Submition::whereStatus('v')
            ->count();
        return view('adminpanel.index', compact('CompCount' , 'WinnerCount' , 'AllComment' ,'AllSubmitions'));
    }

    /**
     * Admin paneļa meklēšana universālā
     *
     * @param Request $request
     * @param ApUser $apuser
     * @param ApComp $apcomp
     * @return \Illuminate\View\View
     */
    public function find(Request $request , ApUser $apuser ,  ApComp $apcomp)
    {
        if($request->get('veids') == 'user')
        {
            return $apuser->find($request);
        }
        if($request->get('veids') == 'comp')
        {
            return $apcomp->find($request);
        }
    }

    /**
     * Lietotāja paneļa izsaukšana
     *
     * @return \Illuminate\View\View
     */
    public function UserPanel()
    {
        $CompCount = Comp::whereUserId(Auth::user()->id)
            ->whereStatus('v')
            ->count();
        $WinnerCount = Winner::join('votings', 'winners.voting_id', '=', 'votings.id')
            ->join('comps' , 'votings.comp_id' ,'=', 'comps.id')
            ->where('comps.user_id', Auth::user()->id)
            ->count('winners.id');
        $YourComment = Comment::whereUserId(Auth::user()->id)
            ->whereStatus('v')
            ->count();
        $YourSubmitions = Submition::whereUserId(Auth::user()->id)
            ->whereStatus('v')
            ->count();
        $CompComments = Comment::whereHas('comp', function($q)
            {
                $q->where('user_id', Auth::user()->id);

            })->orderBy('created_at' , 'DESC')
            ->whereStatus('v')
            ->take(5)
            ->get();
        $CompEntrys = Submition::whereHas('comp', function($q)
        {
            $q->where('user_id', Auth::user()->id);

        })->orderBy('created_at' , 'DESC')
            ->whereStatus('v')
            ->take(5)
            ->get();
        return view('userpanel/index' , compact('CompCount' , 'WinnerCount' , 'YourComment' , 'YourSubmitions' , 'CompComments' , 'CompEntrys'));
    }
}
