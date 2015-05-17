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
	 * Parāda pašlaik esošos konkursus
	 *
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

    public function accept_comp(Comp $comp , User $user, $id)
    {
        $comp = $comp->whereId($id)->first();
        $comp->status = 'v';
        $comp->save();
        $this->acceptNotif($comp, $user);
        \Session::flash('flash_message', 'Konkurss ir apstiprināts!');
        return redirect('adminpanel/comps/accept');
    }
    public function find(Request $request)
    {
        $comps = Comp::where('title', 'LIKE', '%'. $request->get('s') .'%')
            ->orWhere('genre', 'LIKE', '%'. $request->get('s') .'%')
            ->orWhere('song_title', 'LIKE', '%'. $request->get('s') .'%')
            ->paginate(10);
        $header ='Meklēšanas "'.$request->get('s').'" rezultāti';
        return view('adminpanel.comps.index' , compact( 'comps'));
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
