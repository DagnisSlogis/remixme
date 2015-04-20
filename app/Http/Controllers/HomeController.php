<?php namespace App\Http\Controllers;

use App\Comp;
use App\User;
use Carbon\Carbon;

class HomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{

	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index(Comp $comp , User $user)
	{
        $authors = [];
        $comps = $comp->where('subm_end_date' , '>=' , Carbon::now())->get();
        foreach ($comps as $index => $comp) {
            $authors[$index]= $user->find($comp->user_id)->profile_img;
        }
        return view('home' , compact('comps' , 'authors'));
	}

}
