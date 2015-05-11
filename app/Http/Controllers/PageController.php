<?php namespace App\Http\Controllers;

use App\Comment;
use App\Comp;
use App\Http\Requests;
use Auth;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class PageController extends Controller {

	public function AdminPanel()
    {
        return view('adminpanel.index');
    }
    public function UserPanel()
    {
        $CompCount = Comp::whereUserId(Auth::user()->id)
            ->whereStatus('v')
            ->count();
        $WinnerCount = 0;
        $YourComment = Comment::whereUserId(Auth::user()->id)
            ->whereStatus('v')
            ->count();
        return view('userpanel/index' , compact('CompCount' , 'WinnerCount' , 'YourComment'));
    }
}
