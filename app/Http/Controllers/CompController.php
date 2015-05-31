<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Comp;
use App\Http\Requests\EditCompRequest;
use App\Submition;
use App\User;
use App\Comment;
use App\Voting;
use Auth;
use App\Http\Requests\CreateCompRequest;
use Carbon\Carbon;
use App\Http\Controllers\Admin\ApCompController as Admin;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Http\Request;
use App\Http\Controllers\VotingController;

class CompController extends Controller {

    /**
     * Pieejas liegšana viesiem, izņemot dažas lapas.
     *
     */
    public function __construct()
    {
        $this->middleware('auth',  [ 'except' => array('index','soonEnds','popular','show','find')]);
    }

    /**
     * Parāda konkursus sākumlapā
     *
     * @return \Illuminate\View\View
     */
	public function index()
    {
        $comps = Comp::where('subm_end_date' , '>' , Carbon::now())
            ->whereStatus('v')
            ->orderBy('created_at' , 'desc')
            ->paginate(5);
        return view('home' , compact('comps'));
    }

    /**
     * Parāda konkursus, kuri drīz beigsies
     *
     * @return \Illuminate\View\View
     */
    public function soonEnds()
    {
        $comps = Comp::where('subm_end_date' , '>' , Carbon::now())
            ->whereStatus('v')
            ->orderBy('subm_end_date' , 'asc')
            ->paginate(5);
        return view('home' , compact('comps'));
    }

    /**
     * Parāda populārākos kunkursus
     *
     * @return \Illuminate\View\View
     */
    public function popular()
    {

        $comps = Comp::select(
            '*',
            DB::raw("(SELECT COUNT(*) FROM `submitions` WHERE `comp_id` = `comps`.`id`) AS 'count'")
        )
            ->where('subm_end_date' , '>' , Carbon::now())
            ->whereStatus('v')
            ->orderBy('count', 'desc')
            ->paginate(5);
        return view('home')->with('comps',$comps);
    }

	/**
	 * Konkursa izveides skata izveidošana
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('comps/create');
	}

    /**
     * Saglabā konkursu
     *
     * @param CreateCompRequest $request
     * @return Response
     */
	public function store( CreateCompRequest $request)
    {
        $competition = $this->saveImg($request);
        if($competition['preview_type'] == 'y')
        {
            $competition = $this->youtubeConverter($competition);
        }
        if($competition['subm_end_date'] >= $competition['comp_end_date'] OR $competition['subm_end_date'] <= Carbon::now())
        {
            \Session::flash('flash_message', 'Datumiem jābūt atšķirīgiem un lielākiem par šodienas');
            return redirect()->back()->withInput();
        }
        $comp =  new Comp($competition);
        Auth::user()->comps()->save($comp);
        $this->newVoting($comp);
        \Session::flash('success_message', 'Konkurss veiskmīgi reģistrēts, gaidiet apstiprinājumu!');
        return redirect('/');
	}

    /**
     * Izsauc kāda konkursa labošanu
     *
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit($id)
    {
        $comp = Comp::whereId($id)->first();
        if($comp->user_id == Auth::user()->id OR Auth::user()->isAdmin())
        {
            return view('userpanel.comps.edit', compact('comp'));
        }
        else
        {
            \Session::flash('error_message', 'Jūs neesiet šī konkursa autors');
            return redirect()->back();
        }
    }

    /**
     * Saglabā labotos datus datubāzē. nelabotos izlaiž.
     *
     * @param $id
     * @param EditCompRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update( $id ,  EditCompRequest $request )
    {
        $comp = Comp::whereId($id)->first();
        $changes = 0;
        if($comp->title != $request['title'])
        {
            $comp->title = $request['title'];
            $changes = 1;
        }
        if($comp->preview_type != $request['preview_type'] OR $comp->preview_link != $request['preview_link'])
        {
            if($request['preview_type'] == 'y')
            {
                $request = $this->youtubeConverter($request);
            }
            $comp->preview_type = $request['preview_type'];
            $comp->preview_link = $request['preview_link'];
            $changes = 1;
        }
        if($comp->stem_link != $request['stem_link'])
        {
            $comp->stem_link = $request['stem_link'];
            $changes = 1;
        }
        if($request->hasFile('header_img'))
        {
            $request = $this->saveImg($request);
            $comp->header_img = $request['header_img'];
            $changes = 1;
        }
        if($comp->song_title != $request['song_title'])
        {
            $comp->song_title = $request['song_title'];
            $changes = 1;
        }
        if($comp->genre != $request['genre'] OR $comp->bpm != $request['bpm'])
        {
            $comp->genre = $request['genre'];
            $comp->bpm = $request['bpm'];
            $changes = 1;
        }
        if($comp->description != $request['description'])
        {
            $comp->description = $request['description'];
            $changes = 1;
        }
        if($comp->rules != $request['rules'])
        {
            $comp->rules = $request['rules'];
            $changes = 1;
        }
        if($comp->prizes != $request['prizes'])
        {
            $comp->prizes = $request['prizes'];
            $changes = 1;
        }
        if($comp->url != $request['url'] OR $comp->facebook != $request['facebook'] OR $comp->twitter != $request['twitter'])
        {
            $comp->url = $request['url'];
            $comp->facebook = $request['facebook'];
            $comp->twitter = $request['twitter'];
            $changes = 1;
        }
        // Saglabā datus, ja ir notikusi vismaz viena izmaiņa.
        if($changes == 1)
        {
            $comp->save();
            $this->changeVoting($comp);
            \Session::flash('flash_message', 'Konkursa dati ir veiksmīgi laboti!');
            // Pārbauda kas labotāju
            if(Auth::user()->isAdmin())
            {
                return redirect('adminpanel/comps');
            }
            return redirect('userpanel/comps');
        }
        else{
            \Session::flash('flash_message', 'Nekas nav mainīts!');
            return redirect()->back();
        }
    }
    /**
     * Parāda konkursa nolikumu pilnā izmērā ar komentāriem, vai pāradresē uz citu lapu, ja
     * konkurss ir citā posmā vai neaktīvs.
     *
     * @param  int $id
     * @return Response
     */
    public function show( $id , VotingController $voting)
    {
        $comp = Comp::whereId($id)->with('user')->first();
        //Viesis var apsaktīti tikai 1. posma konkursus.
        if(Auth::guest())
        {
            if ($comp->subm_end_date > Carbon::now() && $comp->status == 'v')
            {
                $comments = Comment::whereCompId($comp->id)
                    ->whereStatus('v')
                    ->with('user')
                    ->orderBy('created_at', 'desc')
                    ->paginate(5);
                return view('pages.show', compact('comp', 'comments'));
            }
            else {
                return redirect()->back();
            }
        }
        else
        {
            // Kad un kurš konkursu var apskatīt.
            if ($comp->subm_end_date > Carbon::now() && $comp->status == 'v' OR $comp->status == 'a' && Auth::user()->isAdmin() OR $comp->status == 'a' && Auth::user()->isOwner($comp)) {
                $comments = Comment::whereCompId($comp->id)
                    ->whereStatus('v')
                    ->with('user')
                    ->orderBy('created_at', 'desc')
                    ->paginate(5);
                return view('pages.show', compact('comp', 'comments'));
            }
            elseif($comp->subm_end_date <= Carbon::now() && $comp->comp_end_date > Carbon::now() && $comp->voting_type == 'b' && $comp->status == 'v'){
                return $voting->show($id);
            }
            // Konkursa apskatīšana 3. posmā.
            elseif($comp->comp_end_date < Carbon::now() && $comp->status == 'v')
            {
                $comments = Comment::whereCompId($comp->id)
                    ->whereStatus('v')
                    ->with('user')
                    ->orderBy('created_at', 'desc')
                    ->paginate(5);
                return view('pages.show', compact('comp', 'comments'));
            }
            else {
                return redirect()->back();
            }
        }
    }

    /**
     * Meklē konkursu pēc nosaukumiem, žanra.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function find(Request $request)
    {
        $comps = Comp::whereNested(function($query)use($request)
        {
            $query->where('genre', 'LIKE', '%'. $request->get('s') .'%')
                ->orWhere('song_title', 'LIKE', '%'. $request->get('s') .'%')
                ->orWhere('title', 'LIKE', '%'. $request->get('s') .'%');
        })->where('status', '=' ,'v')
            ->where('subm_end_date' , '>' , Carbon::now())
            ->orderBy('created_at' , 'desc')
            ->paginate(5);
        return view('home' , compact('comps'));
    }

    /**
     * Dzēšs remiksu konkursu un tā balsošanu.
     *
     * @param Admin $admin
     * @param  int $id
     * @return Response
     */
    public function destroy(Admin $admin , $id)
    {
        $comp = Comp::whereId($id)->first();
        if($comp->user_id == Auth::user()->id OR Auth::user()->isAdmin())
        {
            $comp->status = 'b';
            $comp->save();
            $voting = Voting::whereCompId($comp->id)->first();
            $voting->status = 'b';
            $voting->save();
            $user = User::whereId($comp->user_id)->first();
            if(Auth::user()->isAdmin() && Auth::user()->id != $comp->user_id)
            {
                $admin->deleteCompNotif($user, $comp);
            }
            \Session::flash('flash_message', 'Konkurss ir veiksmīgi dzēsts!');
            return redirect()->back();
        }
        else
        {
            \Session::flash('error_message', 'Jūs neesiet šī konkursa autors');
            return redirect()->back();
        }

    }

    /**
     * Apstrādā ievadīto attēlu.
     *
     * @param $request
     * @return mixed
     */
    public function saveImg($request)
    {
        if($request->hasFile('header_img'))
        {
            $file = $request->file('header_img');
            $img = Image::make($file)->fit(610, 140);
            $fileName = rand(1, 9999). '-' . $file->getClientOriginalName();
            $fileName = str_replace(' ', '-', $fileName);
            $img->save('uploads/comp_headers/' . $fileName);
            $comp = $request->all();
            $comp['header_img'] = '/uploads/comp_headers/' . $fileName;
            return $comp;
        }
        else
        {
            $comp = $request->all();
            $comp['header_img'] = '/img/noImg.jpg';
            return $comp;
        }
    }

    /**
     * Konvertē youtube linku uz nepieciešamo (embed)
     *
     * @param $request
     * @return mixed
     */
    public function youtubeConverter($request)
    {
        $request['preview_link'] = str_replace(['watch?v='], ['embed/'] , $request['preview_link']);
        return $request;
    }

    /**
     * Sagatavo voting tabulu, konkursa rezultātu apstiprināšanai
     *
     * @param $comp
     */
    private function newVoting($comp)
    {
        $voting = new Voting;
        $voting->comp_id = $comp->id;
        if($comp->voting_type == 'z')
        {
            $voting->show_date = $comp->subm_end_date->addDays(1);
        }
        else
        {
            $voting->show_date = $comp->comp_end_date->addDays(1);
        }
        $voting->save();
    }

    /**
     * Labo voting tabulas, ierakstu
     * @param $comp
     */
    private function changeVoting($comp)
    {
        $voting = Voting::whereCompId($comp->id)->first();
        if($comp->voting_type == 'z')
        {
            $voting->show_date = $comp->subm_end_date->addDays(1);
        }
        else
        {
            $voting->show_date = $comp->comp_end_date->addDays(1);
        }
        $voting->save();
    }

}
