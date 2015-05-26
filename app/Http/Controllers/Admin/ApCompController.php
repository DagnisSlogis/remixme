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
     * Parāda pašlaik esošos konkursus
     *
     * @param Comp $comp
     * @return Response
     */
	public function index(Comp $comp )
	{
        $comps = $comp->whereNotIn('status' , array('d' , 'a'))
            ->where('comp_end_date', '>=' , Carbon::now())
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('adminpanel.comps.index' , compact( 'comps'));
	}

    /**
     * Parāda visus apstiprinājumu gaidošos konkursus
     *
     * @param Comp $comp
     * @return \Illuminate\View\View
     */
    public function accept(Comp $comp)
    {
        $comps = $comp->whereStatus('a')
            ->where('comp_end_date', '>=' , Carbon::now())
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('adminpanel.comps.accept' , compact('comps'));
    }

    /**
     * Apstiprina konkursu
     *
     * @param Comp $comp
     * @param User $user
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function accept_comp(Comp $comp , User $user, $id)
    {
        $comp = $comp->whereId($id)->first();
        $comp->status = 'v';
        $comp->save();
        $this->acceptNotif($comp, $user);
        \Session::flash('flash_message', 'Konkurss ir apstiprināts!');
        return redirect('adminpanel/comps/accept');
    }

    /**
     * Meklē starp konkursiem
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function find(Request $request)
    {
        $comps = Comp::where('title', 'LIKE', '%'. $request->get('s') .'%')
            ->orWhere('genre', 'LIKE', '%'. $request->get('s') .'%')
            ->orWhere('song_title', 'LIKE', '%'. $request->get('s') .'%')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        $header ='Meklēšanas "'.$request->get('s').'" rezultāti';
        return view('adminpanel.comps.index' , compact( 'comps'));
    }

    /**
     * Izveido sarakstu ar konkursiem, kuri ir beigušies.
     *
     * @param Comp $comp
     * @return \Illuminate\View\View
     */
    public function hasEnded(Comp $comp)
    {
        $comps = $comp->whereNotIn('status', array('b'))
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
