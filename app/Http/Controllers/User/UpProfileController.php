<?php namespace App\Http\Controllers\User;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class UpProfileController extends Controller {

	public function index(User $user)
    {
        $user = $user->whereId(Auth::user()->id)->first();
        return view('userpanel.editprofile' , compact('user'));
    }
    public function update(User $user , Request $request)
    {
        $user = $user->whereId(Auth::user()->id)->first();
        if($user->username != $request->get('username') && $request->get('username') != null)
        {
            $this->validate($request , ['username' => 'required|min:4|max:255|unique:users']);
            $user->username = $request->get('username');
        }
        if($user->email != $request->get('email') && $request->get('email') != null)
        {
            $this->validate($request , ['email' => 'required|email|min:5|max:255|unique:users']);
            $user->email = $request->get('email');
        }
        if($request->get('password') == $request->get('password_confirmation') && $request->get('password') != null)
        {
            $this->validate($request , ['password' => 'required|confirmed|min:8']);
            $user->password = bcrypt($request->get('password'));
        }
        elseif($request->get('password') != $request->get('password_confirmation') )
        {
            \Session::flash('flash_message', 'Jaunā parole nesakrīt!');
            return redirect()->back();
        }
        if ( $request->get('delete_img') == 1)
        {
            $user->profile_img = '/img/noImg.jpg';
        }
        elseif ($request->hasFile('profile_img_link') && $request->get('delete_img') != 1)
        {
            $this->validate($request , ['profile_img_link' => 'image|max:1000|mimes:jpeg,png']);
            $fileName = $this->saveImg($request);
            $user->profile_img = '/uploads/'.$fileName;
        }
        if($user->facebook != $request->get('facebook'))
        {
            $user->facebook = $request->get('facebook');
        }
        $user->save();
        return redirect('/userpanel');
    }
    private function saveImg($request)
    {
        $file = $request->file('profile_img_link');
        $img = Image::make($file)->fit(60);
        $fileName =$request->get('username') . '-' . $file->getClientOriginalName();
        $img->save('uploads/'.$fileName);
        return $fileName;
    }
}
