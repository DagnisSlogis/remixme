<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use Illuminate\Http\Request;

class UserPanelController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('userpanel/index');
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function edit_profile(User $user)
	{
        $user = $user->whereId(Auth::user()->id)->first();
        return view('userpanel.editprofile' , compact('user'));
	}

    /**
     * Upadate users profile
     *
     * @param User $user
     * @param Request $request
     * @return string
     */
    public function patch_user(User $user , Request $request)
    {
        $user = $user->whereId(Auth::user()->id)->first();
        if($user->username != $request->get('username'))
        {
            $user->username = $request->get('username');
        }
        if($user->email != $request->get('email'))
        {
            $user->email = $request->get('email');
        }
        if($request->get('password') == $request->get('password_confirmation') && $request->get('password') != null)
        {
            $user->password = bcrypt($request->get('password'));
            $changes = 1;
        }
        if ( $request->get('delete_img') == 1)
        {
            $user->profile_img = '/img/noImg.jpg';
        }
        elseif ($request->hasFile('profile_img_link') && $request->get('delete_img') != 1)
        {
            $fileName = $this->saveImg($request);
            $user->profile_img = '/uploads/'.$fileName;
            $changes = 1;
        }
        if($user->facebook != $request->get('facebook') && $request->get('facebook') != null)
        {
            $user->facebook = $request->get('facebook');
        }
        $user->save();
        return redirect('/userpanel');
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

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
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
	public function update()
	{
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

    public function saveImg($request)
    {
        $file = $request->file('profile_img_link');
        $fileName = $request->get('username').'-'.$file->getClientOriginalName();
        $file->move(public_path().'/uploads', $fileName);
        return $fileName;
    }

}
