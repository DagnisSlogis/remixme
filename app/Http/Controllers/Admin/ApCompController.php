<?php namespace App\Http\Controllers\Admin;

use App\Comment;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Comp;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ApCompController extends Controller {

    /**
     * Pieejas liegšana dažādam lietotāja grupām kontroliera funkcijām
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Parāda pašlaik notiekošos
     *
     * @return \Illuminate\View\View
     */
    public function index()
	{
        $comps = Comp::whereNotIn('status' , array('b' , 'a'))
            ->where('comp_end_date', '>' , Carbon::now())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        $header = "Pašlaik notiek";
        return view('adminpanel.comps.index' , compact( 'comps' , 'header'));
	}

    /**
     * Parāda visus apstiprinājumu gaidošos konkursus
     *
     * @return \Illuminate\View\View
     */
    public function accept()
    {
        $comps = Comp::whereStatus('a')
            ->where('comp_end_date', '>' , Carbon::now())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('adminpanel.comps.accept' , compact('comps'));
    }

    /**
     * Apstiprina konkursu
     *
     * @param User $user
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function accept_comp($id , User $user)
    {
        $comp = Comp::whereId($id)->first();
        $comp->status = 'v';
        $comp->save();
        $this->acceptNotif($comp, $user);
        \Session::flash('flash_message', 'Konkurss ir apstiprināts!');
        return redirect('adminpanel/comps/accept');
    }

    /**
     * Meklē konkursu adminpanelī
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function find(Request $request)
    {
        $comps = Comp::whereNested(function($query)use($request)
        {
            $query->where('title', 'LIKE', '%'. $request->get('s') .'%')
                ->orWhere('genre', 'LIKE', '%'. $request->get('s') .'%')
                ->orWhere('song_title', 'LIKE', '%'. $request->get('s') .'%');
        })->where('status', '=' ,'v')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        $header ='Meklēšanas "'.$request->get('s').'" rezultāti';
        return view('adminpanel.comps.index' , compact( 'comps' , 'header'));
    }

    /**
     * Izveido sarakstu ar konkursiem, kuri ir beigušies.
     *
     * @return \Illuminate\View\View
     */
    public function hasEnded()
    {
        $comps = Comp::whereNotIn('status', array('b'))
            ->where('comp_end_date', '<=' , Carbon::now())
            ->paginate(5);
        $header = "Beigušies konkursi";
        return view('adminpanel.comps.hasended', compact('comps', 'header'));
    }

    /**
     * Paziņo konkursa autoram, ka viņa konkurss ir apstiprināts.
     *
     * @param $comp
     * @param $user
     */
    private function acceptNotif($comp , $user)
    {
        $user = $user->whereId($comp->user_id)->first();
        $user->newNotification()
            ->withType('CompAccepted')
            ->withSubject('Tavs konkurss ir apstiprināts')
            ->withTitle($comp->title)
            ->withComp($comp->id)
            ->save();
    }

    /**
     * Paziņo, ka administrātors ir dzēsis tavu konkursu.
     *
     * @param $user
     * @param $comp
     */
    public function deleteCompNotif($user, $comp)
    {
        $user->newNotification()
            ->withType('CompDenied')
            ->withSubject('Tavs konkurss ir noraidīts vai/un dzēsts')
            ->withTitle($comp->title)
            ->withComp($comp->id)
            ->save();
    }
}
