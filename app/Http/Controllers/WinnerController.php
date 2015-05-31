<?php namespace App\Http\Controllers;

use App\Comp;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Carbon\Carbon;
use Illuminate\Http\Request;

class WinnerController extends Controller {

    /**
     * Neļauj viesim izsaukt šī kontroliera funkcijas.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Uzvarētāju lapa
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $comps = Comp::where('comp_end_date' , '<=' , Carbon::now())
            ->whereHas('voting', function($q)
            {
                $q->where('status', 'b');
            })
            ->whereStatus('v')
            ->paginate(5);
        return view('pages.winner', compact('comps'));
    }

    /**
     * Konkursu meklēšana uzvarētāju lapā
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function find(Request $request)
    {
        $comps = Comp::where('status', '=' ,'v')
            ->where('comp_end_date' , '<=' , Carbon::now())
            ->whereNested(function($query)use($request)
            {
                $query->where('title', 'LIKE', '%'. $request->get('s') .'%')
                    ->orWhere('genre', 'LIKE', '%'. $request->get('s') .'%')
                    ->orWhere('song_title', 'LIKE', '%'. $request->get('s') .'%');
            })->orderBy('subm_end_date' , 'desc')
            ->paginate(5);
        return view('pages.winner' , compact('comps'));
    }

}
