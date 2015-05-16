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
        }
        if ( $request->get('delete_img') == 1)
        {
            $user->profile_img = '/img/noImg.jpg';
        }
        elseif ($request->hasFile('profile_img_link') && $request->get('delete_img') != 1)
        {
            $fileName = $this->saveImg($request);
            $user->profile_img = '/uploads/'.$fileName;
        }
        if($user->facebook != $request->get('facebook') && $request->get('facebook') != null)
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
