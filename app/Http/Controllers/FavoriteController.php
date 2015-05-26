<?php namespace App\Http\Controllers;

use App\Comp;
use App\Favorite;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use App\Notification;

class FavoriteController extends Controller
{
    /**
     * Pieejas liegšana viesiem
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * @param Favorite $favorite
     * @return \Illuminate\View\View
     */
    public function index(Favorite $favorite)
    {
        $favorites = $favorite->whereUserId(Auth::user()->id)
            ->whereStatus('v')
            ->with('comp')
            ->paginate(10);
        return view('userpanel.favorite' , compact('favorites'));
    }
    /**
     * @param $id
     * @param Favorite $favorite
     * @return \Illuminate\Http\RedirectResponse
     */
    public function add($id , Favorite $favorite )
    {
        $check = $favorite
            ->whereUserId(Auth::user()->id)
            ->whereCompId($id)
            ->whereStatus('v')
            ->get();
        if($check->isEmpty())
        {
            $favorite = new Favorite();
            $favorite->user_id = Auth::user()->id;
            $favorite->comp_id = $id;
            $favorite->save();
            $this->NotifToAuthor($id , $favorite);
            $this->NotifUser($id);
            \Session::flash('success_message', 'Konkurss veiksmīgi pievienots tavam favorītu sarakstam!');
        }
        else {
            \Session::flash('error_message', 'Konkurss ir jau pievienots tavam favorītu sarakstam!');

        }
        return redirect()->back();
    }

    /**
     * @param $id
     * @param Favorite $favorite
     * @param Notification $notification
     */
    public function delete($id , Favorite $favorite )
    {
        $favorite = $favorite->whereId($id)->first();
        $notif = Notification::whereCompId($favorite->comp_id)
            ->whereUserId($favorite->user_id)
            ->whereType('CompEnded')->first();
        $notif->delete();
        $notif = Notification::whereCompId($favorite->comp_id)
            ->whereUserId($favorite->user_id)
            ->whereType('SubmitionEnded')->first();
        $notif->delete();
        $favorite->status = 'd';
        $favorite->save();
        return redirect()->back();
    }

    /**
     * Izveido atgādinājumu r.k. autoram.
     *
     * @param $id
     */
    private function NotifToAuthor($id)
    {
        $comp = Comp::whereId($id)->first();
        $comp_author = User::whereId($comp->user_id)->first();
        $comp_author->newNotification()
            ->withType('SomeOnFavorited')
            ->withSubject('Lietotājs '.Auth::user()->username.' pievienojis favorītiem tavu konkursu')
            ->withTitle($comp->title)
            ->withComp($comp->id)
            ->save();
    }

    private function NotifUser($id)
    {
        $comp = Comp::whereId($id)->first();
        $state = $this->checkNotif($comp->id);
        if($state == false) {
            $user = Auth::user();
            $user->newNotification()
                ->withType('SubmitionEnded')
                ->withSubject('Konkursa remiksu iesūtīšanas termiņš ir beidzies')
                ->withTitle($comp->title)
                ->withShowDate($comp->subm_end_date)
                ->withComp($comp->id)
                ->save();
            $user->newNotification()
                ->withType('CompEnded')
                ->withSubject('Konkurss ir beidzies')
                ->withTitle($comp->title)
                ->withShowDate($comp->comp_end_date)
                ->withComp($comp->id)
                ->save();
        }
    }
    /**
     * Favorītu pārbaude, pārbauda tikai vienu, jo vienmēr tiek izveidoti abi.
     *
     * @param $id
     * @return bool
     */
    private function checkNotif($id)
    {
        if(count(Notification::whereCompId($id)->whereType('SubmitionEnded')->get()))
        {
            return true;
        }
        else
            return false;
    }
}
