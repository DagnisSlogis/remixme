<?php namespace App\Http\Controllers\User;

use App\Comp;
use App\Http\Requests;
use App\Http\Controllers\Controller;
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
            ->whereNotIn('status', array('d'))
            ->where('comp_end_date', '>' , Carbon::now())
            ->paginate(10);
        $header = "Visi konkursi";
        return view('userpanel.comps.index', compact('comps', 'header'));
    }

    public function hasEnded(Comp $comp)
    {
        $comps = $comp->whereUserId(Auth::user()->id)
            ->whereNotIn('status', array('d'))
            ->where('comp_end_date', '<=' , Carbon::now())
            ->paginate(10);
        $header = "Beigušies konkursi";
        return view('userpanel.comps.index', compact('comps', 'header'));
    }

}
