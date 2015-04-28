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
	public function index(Comp $comp , User $user)
	{
        $comps = $comp->whereNotIn('status' , array('d' , 'a'))
            ->where('comp_end_date', '>=' , Carbon::now())
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('adminpanel.comps.index' , compact( 'comps'));
	}

    public function accept(Comp $comp , User $user)
    {
        $comps = $comp->whereStatus('a')
            ->where('comp_end_date', '>=' , Carbon::now())
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('adminpanel.comps.accept' , compact('comps'));
    }

    public function accept_comp(Comp $comp , User $user , $id)
    {
        $comp = $comp->whereId($id)->first();
        $user = $user->whereId($comp->user_id)->first();
        $comp->status = 'v';
        $comp->save();
        $user->newNotification()
            ->withType('CompAccepted')
            ->withSubject('Tavs konkurss ir apstiprināts')
            ->withTitle($comp->title)
            ->regarding($comp)
            ->save();
        \Session::flash('flash_message', 'Konkurss ir apstiprināts!');
        return redirect('adminpanel/comps/accept');
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	public function show()
    {
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(Comp $comp, User $user, $id)
	{
        $comp = $comp->whereId($id)->first();
        $comp->status = 'd';
        $comp->save();
        $user = $user->whereId($comp->user_id)->first();
        $user->newNotification()
            ->withType('CompDenied')
            ->withSubject('Tavs konkurss ir noraidīts un dzēsts')
            ->withTitle($comp->title)
            ->regarding($comp)
            ->save();
        \Session::flash('flash_message', 'Konkurss ir veiksmīgi dzēsts!');
        return redirect('adminpanel/comps');
	}

}
