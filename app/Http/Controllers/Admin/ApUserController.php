<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Submition;
use App\User;
use App\Voting;
use App\Comp;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class ApUserController extends Controller {


    /**
     * Pieejas liegšana dažādam lietotāja grupām kontroliera funkcijām
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Izveido skatu ar visiem sistēmas lietotājiem
     *
     * @param User $user
     * @return \Illuminate\View\View
     */
    public function index(User $user){
        $header = "Visi lietotāji";
        $users = $user->orderBy('created_at', 'desc')->paginate(10);
        return view('adminpanel.user.changeusers' , compact('users' , 'header'));
    }

    /**
     * Iegūst izvēlētā lietotāja datus un izveido skatu ar labošanas formai.
     *
     * @param User $user
     * @param $id
     * @return \Illuminate\View\View
     */
    public function edit(User $user, $id){
        $user = $user->whereId($id)->first();
        return view('adminpanel.user.edit' , compact('user'));
    }

    /**
     * Saglabā mainitos lietotāja datus, pirms saglabā pārbauda.
     *
     * @param User $user
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(User $user, Request $request, $id ){
        $user = $user->whereId($id)->first();
        $changes = 0;
        if($user->username != $request->get('username') && $request->get('username') != null)
        {
            $this->validate($request , ['username' => 'required|min:4|max:255|unique:users']);
            $user->username = $request->get('username');
            $changes = 1;
        }
        if($user->email != $request->get('email') && $request->get('email') != null)
        {
            $this->validate($request , ['email' => 'required|email|min:5|max:255|unique:users']);
            $user->email = $request->get('email');
            $changes = 1;
        }
        if($request->get('password') == $request->get('password_confirmation') && $request->get('password') != null)
        {
            $this->validate($request , ['password' => 'required|confirmed|min:8']);
            $user->password = bcrypt($request->get('password'));
            $changes = 1;
        }
        elseif($request->get('password') != $request->get('password_confirmation') )
        {
            \Session::flash('flash_message', 'Jaunā parole nesakrīt!');
            return redirect()->back();
        }
        if ( $request->get('delete_img') == 1)
        {
            $user->profile_img = '/img/noImg.jpg';
            $changes = 1;
        }
        elseif ($request->hasFile('profile_img_link') && $request->get('delete_img') != 1){
            $this->validate($request , ['profile_img_link' => 'image|max:1000|mimes:jpeg,png']);
            $file = $request->file('profile_img_link');
            $img = Image::make($file)->fit(60);
            $fileName = $request->get('username').'-'.$file->getClientOriginalName();
            $img->save('uploads/'.$fileName);
            $user->profile_img = '/uploads/'.$fileName;
            $changes = 1;
        }
        if($user->facebook != $request->get('facebook'))
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

    /**
     * Funkcija dzēšs lietotāju
     *
     * @param User $user
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete(User $user , $id){
        $user = $user->whereId($id)->first();
        $user->status =  3;
        $user->save();
        $this->clearComps($user);
        $this->clearSubmitions($user);
        $this->clearComments($user);
        \Session::flash('flash_message', 'Lietotājs ir veiksmīgi izdzēsts!');
        return redirect('adminpanel/users');
    }

    /**
     * Meklē lietotājus
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function find(Request $request){
        $header = 'Meklēšanas "'.$request->get('s').'" rezultāti';
        $users = User::where('username', 'LIKE', '%'. $request->get('s') .'%')
            ->orWhere('email', 'LIKE', '%'. $request->get('s') .'%')->paginate(10);
        return view('adminpanel.user.changeusers' , compact('users' , 'header'));
    }

    /**
     * Dzēšs lietotāja konkursus
     *
     * @param $user
     */
    private function clearComps($user)
    {
        $comps = Comp::whereUserId($user->id)->get();
        if($comps)
        {
            foreach ($comps as $comp)
            {
                $comp->status = 'b';
                $voting = Voting::whereCompId($comp->id)->first();
                $voting->status = 'b';
                foreach($comp->comments as $comment)
                {
                    $comment->status = 'b';
                    $comment->save();
                }
                $voting->save();
                $comp->save();
            }

        }
    }

    /**
     * Dzēšs lietotāja dziesmas, kas vēl nav beigušas dalību konkursā
     * @param $user
     */
    private function clearSubmitions($user)
    {
        $submitions = Submition::whereUserId($user->id)->get();
        if($submitions)
        {
            foreach($submitions as $subm)
            {
                if($subm->voting->status == 'v') {
                    $subm->status = 'b';
                    $subm->save();
                }
                else
                    continue;
            }
        }
    }

    /**
     * Dzēšs lietotāja komentārus
     *
     * @param $user
     */
    private function clearComments($user)
    {
        if($user->comments)
        {
            foreach($user->comments as $comment)
            {
                $comment->status = 'b';
                $comment->save();
            }
        }

    }


}
