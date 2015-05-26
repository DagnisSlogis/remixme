<?php namespace App\Http\Controllers;

use App\Comp;
use App\Favorite;
use App\Http\Requests;
use App\Notification;
use App\Submition;
use App\Voting;
use Auth;
use App\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddSubmitionRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubmitionController extends Controller {

    /**
     * Pieejas liegšana viesiem
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Dziesmas iesūtīšanas funkcija
     *
     * @param $id
     * @param AddSubmitionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store($id , AddSubmitionRequest $request )
    {
        $comp = Comp::whereId($id)->first();
        $this->userNotif($comp->id);
        $this->checkEntrys($id);
            $submition =  new Submition;
            $submition->title = $request['title'];
            $submition->link = $request['link'];
            $submition->comp_id = $id;
            $submition->user_id = Auth::user()->id;
            $submition->voting_id = $comp->voting->id;
            $submition->save();
        $this->CompNotif($submition);
        \Session::flash('success_message', 'Dziesma veiksmīgi pievienota konkursam!');
        return redirect()->back();
    }

    /**
     * Parāda lietotāja iesūtītās dziesmas
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $songs = Submition::whereUserId(Auth::user()->id)
            ->whereStatus('v')
            ->paginate(10);
        return view('userpanel.mysongs' , compact('songs'));
    }


    /**
     * Konkursa autors, administrators apskata konkursa iesūtītas dziesmas
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function compSubmitions($id)
    {
        $comp = Comp::whereId($id)->first();
        if($comp->user_id == Auth::user()->id || Auth::user()->isAdmin())
        {
            $submitions = Submition::whereCompId($id)
                ->whereStatus('v')
                ->paginate(10);
            $comp = Comp::whereId($id)->first();
            $header = $comp->title . ' : remiksi';
            return view('userpanel.comps.submitions', compact('submitions', 'header'));
        }
        else
        {
            \Session::flash('error_message', 'Jūs neesiet šī konkursa autors');
            return redirect()->back();
        }
    }


    /**
     * Dzēšs nevēlamos remiksus no konkursa
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete($id)
    {
        $submition = Submition::whereId($id)->first();
        if($submition->comp->subm_end_date > Carbon::now())
        {
            //Attīram balošanas sarakstu
            $submition->status = 'b';
            $submition->save();
            $this->deleteNotif($submition);
            $this->deleteReminders($submition);
            \Session::flash('flash_message', 'Dziesma ir veiksmīgi izdzēsta!');
            return redirect()->back();
        }
        else{
            \Session::flash('flash_message', 'Dziesmu iesūtīšana ir beigusies, jūs nevarat dzēst šo dziesmu!');
            return redirect()->back();
        }
    }



    /**
     * Viens lietotājs vienam konkursam var iesniegt tikai vienu remiksu
     *
     * @param $id
     */
    private function checkEntrys($id)
    {
        $HaveEntered = Submition::whereUserId(Auth::user()->id)
            ->whereCompId($id)
            ->whereStatus('v')
            ->first();
        if($HaveEntered){
            $HaveEntered->status = 'b';
            $HaveEntered->save();
        }
    }

    /**
     * Izveido infromatīvos paziņojumus, ja lietotājs jau tādus nav izveidojis ar fav.
     *
     * @param $submition
     */
    private function compNotif($submition)
    {
        $state = $this->checkNotif($submition->comp_id);
        if($state == false)
        {
            $comp = Comp::whereId($submition->comp_id)->first();
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

    /**
     * Aizsūta paziņojumu r.k. rīkotājam
     *
     * @param $id
     */
    private function userNotif($id)
    {
        $comp = Comp::whereId($id)->first();
        $comp_author = User::whereId($comp->user_id)->first();
        $comp_author->newNotification()
            ->withType('NewSubmition')
            ->withSubject('Lietotājs '.Auth::user()->username.' iesūtījis savu remiksu')
            ->withTitle($comp->title)
            ->withComp($comp->id)
            ->save();
    }

    /**
     * Paziņo remiksa autoram dzēšanas jaunumus
     *
     * @param $submition
     */
    private function deleteNotif($submition)
    {
        $comp = Comp::whereId($submition->comp_id)->first();
        $comp_author = User::whereId($submition->user_id)->first();
        $comp_author->newNotification()
            ->withType('DeleteSubmition')
            ->withSubject('Jūsu remiks "'.$submition->title.'" ir dzēsts')
            ->withTitle($comp->title)
            ->withComp($comp->id)
            ->save();
    }

    /**
     * Dzēšs atgādinājuma paziņojumus, par to ka konkurss ir beidzies
     *
     * @param $submition
     */
    private function deleteReminders($submition)
    {
        $isFav = Favorite::whereUserId($submition->user_id)
            ->whereCompId($submition->comp_id)->first();
        if($isFav)
        {
            return true;
        }
        else
        {
            $notif = Notification::whereCompId($submition->comp_id)
                ->whereUserId($submition->user_id)
                ->whereType('CompEnded')->first();
            if($notif) {
                $notif->delete();
            }
            $notif = Notification::whereCompId($submition->comp_id)
                ->whereUserId($submition->user_id)
                ->whereType('SubmitionEnded')->first();
            if($notif) {
                $notif->delete();
            }
        }
    }
}
