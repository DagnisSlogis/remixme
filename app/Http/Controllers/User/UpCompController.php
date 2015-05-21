<?php namespace App\Http\Controllers\User;

use App\Comp;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Voting;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UpCompController extends Controller {

    /**
     * Funkcija izveido skatu ar lietotāja pašlaik esošajiem ( notiekošajiem ) konkursiem
     *
     * @param Comp $comp
     * @return \Illuminate\View\View
     */
    public function index(Comp $comp)
    {
        $comps = $comp->whereUserId(Auth::user()->id)
            ->whereNotIn('status', array('b'))
            ->where('comp_end_date', '>' , Carbon::now())
            ->paginate(10);
        $header = "Visi konkursi";
        return view('userpanel.comps.index', compact('comps', 'header'));
    }



    /**
     * Izveido sarakstu ar konkursiem, kuri ir beigušies.
     *
     * @param Comp $comp
     * @return \Illuminate\View\View
     */
    public function hasEnded(Comp $comp)
    {
        $comps = $comp->whereUserId(Auth::user()->id)
            ->whereNotIn('status', array('b'))
            ->where('comp_end_date', '<=' , Carbon::now())
            ->paginate(10);
        $header = "Beigušies konkursi";
        return view('userpanel.comps.hasended', compact('comps', 'header'));
    }

    /**
     * Atrod lietotāja konkursus pēc žanra, r.k. nosaukuma un dziesmas nosaukuma.
     *
     * @param Request $request
     * @param Comp $comp
     * @return \Illuminate\View\View
     */
    public function find(Request $request , Comp $comp)
    {
        $comps = $comp->whereUserId(Auth::user()->id)
            ->where('title', 'LIKE', '%'. $request->get('s') .'%')
            ->orWhere('genre', 'LIKE', '%'. $request->get('s') .'%')
            ->orWhere('song_title', 'LIKE', '%'. $request->get('s') .'%')
            ->paginate(10);
        $header ='Meklēšanas "'.$request->get('s').'" rezultāti';
        return view('userpanel.comps.index', compact('comps', 'header'));
    }



}
