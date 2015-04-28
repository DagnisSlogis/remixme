<?php namespace App\Http\Controllers;

use App\Comp;
use App\Favorite;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use Illuminate\Http\Request;

class FavoriteController extends Controller {

    /**
     * @param $id
     * @param Favorite $favorite
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add($id , Favorite $favorite , User $user , Comp $comp)
    {
        $check = $favorite
            ->whereUserId(Auth::user()->id)
            ->whereCompId($id)
            ->get();
        if($check->isEmpty())
        {
            $favorite = new Favorite();
            $favorite->user_id = Auth::user()->id;
            $favorite->comp_id = $id;
            $favorite->save();
            $comp = $comp->whereId($id)->first();
            $comp_author = $user->whereId($comp->user_id)->first();
            $comp_author->newNotification()
                ->withType('SomeOnFavorited')
                ->withSubject('Lietotājs '.Auth::user()->username.' pievienojis favorītiem tavu konkursu')
                ->withTitle($comp->title)
                ->regarding($favorite)
                ->save();
            \Session::flash('success_message', 'Konkurss veiksmīgi pievienots tavam favorītu sarakstam!');
        }
        else {
            \Session::flash('error_message', 'Konkurss ir jau pievienots tavam favorītu sarakstam!');

        }
        return redirect()->back();
    }
}
