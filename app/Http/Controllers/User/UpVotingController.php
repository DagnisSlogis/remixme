<?php namespace App\Http\Controllers\User;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Notification;
use App\Submition;
use App\Winner;
use Carbon\Carbon;
use App\Comp;
use Illuminate\Http\Request;
use App\Voting;
use App\User;
use Auth;
class UpVotingController extends Controller {

    /**
     * Pieejas liegšana viesiem
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Izveido skatu ar lietotāja visiem konkursiem, kuri ir vērtējami
     *
     * @return \Illuminate\View\View
     */
    public function index( Comp $comp)
    {
        $judgings = $comp->where('voting_type','=' , 'z')
            ->whereUserId(Auth::user()->id)
            ->whereHas('voting', function($q)
            {
                $q->where('show_date', '<=' , Carbon::now());
                $q->where('status' , 'v');

            })->paginate(10);
        return view('userpanel.comps.judging' , compact('judgings'));
    }

    /**
     * Izveido skatu ar vērtējamajā konkursa dziesmām, ja nav dziesmu dzēšs
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function judging($id)
    {
        $comp = Comp::whereId($id)->first();
        if($comp->user_id == Auth::user()->id)
        {
            $submCount = Submition::whereCompId($id)
                ->whereStatus('v')
                ->count();
            if($submCount == 0)
            {
                $voting = Voting::whereCompId($id)->first();
                $voting->status = 'b';
                $voting->save();
                $comp->status = 'b';
                $comp->save();
                \Session::flash('flash_message', 'Konkursam nebija neviena iesūtīta dziesma, mums nācās viņu dzēst.');
                return redirect()->back();
            }
            else
            {
                $submitions = Submition::whereCompId($id)
                    ->whereStatus('v')
                    ->get();
                return view('userpanel.comps.submjudge' , compact('submitions' , 'comp'));
            }
        }
        else
        {
            \Session::flash('error_message', 'Jūs neesiet šī konkursa autors');
            return redirect()->back();
        }

    }

    /**
     * Saglabā žūrija vērtēšanu.
     *
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id , Request $request)
    {
        $submCount = Submition::whereCompId($id)
            ->whereStatus('v')
            ->count();
        $checker = Array('0', '0', '0');
        for ($i = 0; $i < $submCount; $i++) {
            if ($request->get('place' . $i) == '1') {
                $checker[0]++;
            }
            if ($request->get('place' . $i) == '2') {
                $checker[1]++;
            }
            if ($request->get('place' . $i) == '3') {
                $checker[2]++;
            }
        }
        if ($checker[0] > 1 OR $checker[1] > 1 OR $checker[2] > 1) {
            \Session::flash('flash_message', 'Katram remiksam jābūt unikālai vietai vai 0.');
            return redirect()->back();
        }
        if ($submCount >= 3) {
            if ($checker[0] == 0 OR $checker[1] == 0 OR $checker[2] == 0) {
                \Session::flash('flash_message', 'Dziesmas jānovērtē obligāti.');
                return redirect()->back();
            }
        }
        if ($submCount == 2)
        {
            if ($checker[0] == 0 OR $checker[1] == 0) {
                \Session::flash('flash_message', 'Dziesmas jānovērtē obligāti.');
                return redirect()->back();
            }
        }
        if($checker[0] == 0 && $submCount == 1)
        {
            \Session::flash('flash_message', 'Novērtējiet');
            return redirect()->back();
        }
        if($this->createWinner($request , $id ,  $submCount))
        {
            \Session::flash('flash_message', 'Konkurss veiksmīgi novērtēts');
            return redirect('/userpanel/judging');
        }

    }

    /**
     * Apskata balsojamos konkursus
     *
     * @return \Illuminate\View\View
     */
    public function voting()
    {
        $votings = Comp::where('voting_type','=' , 'b')
            ->whereUserId(Auth::user()->id)
            ->whereHas('voting', function($q)
            {
                $q->where('status' , 'v');

            })->paginate(10);
        return view('userpanel.comps.voting' , compact('votings'));
    }


    /**
     * Apstiprina balsojumu, vai arī dzēšs ja nebija nevienas dziesmas
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function acceptVoting($id)
    {
        $comp = Comp::whereId($id)->first();
        if($comp->subm_end_date <= Carbon::now() && $comp->user_id == Auth::user()->id)
        {
            $submCount = Submition::whereCompId($id)
                ->whereStatus('v')
                ->count();
            if ($submCount == 0)
            {
                $voting = Voting::whereCompId($id)->first();
                $voting->status = 'b';
                $voting->save();
                $comp = Comp::whereId($id)->first();
                $comp->status = 'b';
                $comp->save();
                \Session::flash('flash_message', 'Konkursam nebija neviena iesūtīta dziesma, mums nācās viņu dzēst.');
                return redirect()->back();
            }
            elseif($comp->comp_end_date < Carbon::now())
            {
                $count = Submition::whereCompId($id)
                    ->whereStatus('v')->count();
                if ($count < 3) {
                    $winners = Submition::whereCompId($id)
                        ->whereStatus('v')
                        ->orderBy('votes', 'DESC')
                        ->get();

                } else {
                    $count = 3;
                    $winners = Submition::whereCompId($id)
                        ->whereStatus('v')
                        ->orderBy('votes', 'DESC')
                        ->take(3)
                        ->get();
                }
                for ($i = 0; $i < $count; $i++) {
                    $this->VotingWinner($winners[$i], $i + 1);
                }
                $voting = Voting::whereCompId($id)->first();
                $voting->status = 'b';
                $voting->save();
                \Session::flash('flash_message', 'Konkursa rezultāts apstiprināts');
                return redirect()->back();
            }
            else
            {
                \Session::flash('error_message', 'Konkursa balsošana vēl nav beigusies');
                return redirect()->back();
            }
        }
        else
        {
            \Session::flash('error_message', 'Jūs neesiet ši konkursa autors.');
            return redirect()->back();
        }
    }


    /**
     * Izveido uzvarētājus
     *
     * @param $request
     * @param $id
     * @param $submCount
     * @return int
     */
    private function createWinner($request , $id ,  $submCount)
    {
        $voting = Voting::whereCompId($id)->first();
        $ok = 0;
        for($i = 0 ;  $i < $submCount ; $i++)
        {
            if($request->get('place'.$i) == '1')
            {
                $winner = New Winner;
                $winner->voting_id = $voting->id;
                $winner->submition_id = $request->get('id'.$i);
                $winner->place = 1;
                $winner->save();
                $this->informAuthor($request->get('id'.$i) , 1 );
                $ok++;
            }
            if($request->get('place'.$i) == '2')
            {
                $winner = New Winner;
                $winner->voting_id = $voting->id;
                $winner->submition_id = $request->get('id'.$i);
                $winner->place = 2;
                $winner->save();
                $this->informAuthor($request->get('id'.$i) , 2 );
                $ok++;
            }
            if($request->get('place'.$i) == '3')
            {
                $winner = New Winner;
                $winner->voting_id = $voting->id;
                $winner->submition_id = $request->get('id'.$i);
                $winner->place = 3;
                $winner->save();
                $this->informAuthor($request->get('id'.$i) , 3 );
                $ok++;
            }
            if($ok == 3)
            {
                break;
            }
        }
        if($ok >= 1)
        {
            $voting->status = 'b';
            $voting->save();
            $comp = Comp::whereId($id)->first();
            $this->speedUpNotif($comp);
            $comp->comp_end_date = Carbon::now();
            $comp->save();
            return 1;
        }
    }

    /**
     * Informē autoru par iegūto vietu
     *
     * @param $id
     * @param $place
     */
    private function informAuthor($id , $place)
    {
        $submition = Submition::whereId($id)->first();
        $user = User::whereId($submition->user_id)->first();
        $user->newNotification()
            ->withType('Winner')
            ->withSubject('Apsveicu, Jūs esat ieguvis '.$place.'. vietu')
            ->withTitle($submition->comp->title)
            ->withComp($submition->comp_id)
            ->save();

    }

    /**
     * Nomaina parādišanas laiku no comp_end_date uz tagad, jo konkurss tika ātrāk beigts
     *
     * @param $comp
     */
    private function speedUpNotif($comp)
    {
        $notifications = Notification::whereCompId($comp->id)
            ->whereType('CompEnded')
            ->get();
        foreach($notifications as $notification)
        {
            $notification->show_date =  null;
            $notification->save();
        }
    }


    /**
     * Izveido Balsojuma uzvarētājus
     *
     * @param $submition
     * @param $place
     */
    private function votingWinner($submition , $place)
    {
        $winner = New Winner;
        $winner->voting_id = $submition->voting_id;
        $winner->submition_id = $submition->id;
        $winner->place = $place;
        $winner->save();
        $this->informAuthor($submition->id, $place );
    }
}
