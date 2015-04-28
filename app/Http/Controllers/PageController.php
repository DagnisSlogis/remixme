<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class PageController extends Controller {

	public function AdminPanel()
    {
        return view('adminpanel.index');
    }
    public function UserPanel()
    {
        return view('userpanel/index');
    }
}
