<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class ApUserController extends Controller {

    public function __construct(User $user){

    }
	public function index(User $user){
        $users = $user->orderBy('created_at', 'desc')->paginate(10);
        return view('adminpanel.user.changeusers' , compact('users'));
    }

    public function edit(User $user, $id){
        $user = $user->whereId($id)->first();
        return view('adminpanel.user.edit' , compact('user'));
    }
    public function update(User $user, Request $request, $id){
        $user = $user->whereId($id)->first();
        $changes = 0;
        if($user->username != $request->get('username') && $request->get('username') != null)
        {
            $user->username = $request->get('username');
            $changes = 1;
        }
        if($user->email != $request->get('email') && $request->get('email') != null)
        {
            $user->email = $request->get('email');
            $changes = 1;
        }
        if($request->get('password') == $request->get('password_confirmation') && $request->get('password') != null)
        {
            $user->password = bcrypt($request->get('password'));
            $changes = 1;
        }
        if ( $request->get('delete_img') == 1)
        {
            $user->profile_img = '/img/noImg.jpg';
            $changes = 1;
        }
        elseif ($request->hasFile('profile_img_link') && $request->get('delete_img') != 1){
            $file = $request->file('profile_img_link');
            $fileName = $request->get('username').'-'.$file->getClientOriginalName();
            $file->move(public_path().'/uploads', $fileName);
            $user->profile_img = '/uploads/'.$fileName;
            $changes = 1;
        }
        if($user->facebook != $request->get('facebook') && $request->get('facebook') != null)
        {
            $user->facebook = $request->get('facebook');
            $changes = 1;
        }
        if($user->status != $request->get('status'))
        {
            $user->status = $request->get('status');
            $changes = 1;
        }
        $user->save();
        if($changes == 1)
        {
            \Session::flash('flash_message', 'Lietotāja dati ir veiksmīgi laboti!');
        }
        return redirect('adminpanel/users');
    }
    public function delete(User $user , $id){
        $user = $user->whereId($id)->first();
        $user->status =  3;
        $user->save();
        \Session::flash('flash_message', 'Lietotājs ir vieksmīgi izdzēsts!');
        return redirect('adminpanel/users');
    }

    /**
     * @param User $user
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function find( User $user , Request $request){
        $users = $user->where('username', 'LIKE', '%'. $request->get('s') .'%')
            ->orWhere('email', 'LIKE', '%'. $request->get('s') .'%')->paginate(10);
        return view('adminpanel.user.changeusers' , compact('users'));
    }
}
