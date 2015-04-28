<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Comp;
use App\Comment;
use Auth;
use App\Http\Requests\CreateCompRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;

class CompController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Comp $comp)
    {
        $comps = $comp->where('subm_end_date' , '>=' , Carbon::now())
            ->with('user' , 'comments')
            ->get();
        return view('home' , compact('comps'));
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('comps/create');
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateCompRequest $request
     * @return Response
     */
	public function store( CreateCompRequest $request , Comp $comp)
    {
        $competition = $this->saveImg($request);
        if($competition['preview_type'] == 'y')
        {
            $competition = $this->youtubeConverter($competition);
        }
        $comp =  new Comp($competition);
        Auth::user()->comps()->save($comp);
        return redirect('/');
	}


    /**
     * Parāda konkursa nolikumu pilnā izmērā ar komentāriem
     *
     * @param Comment $comment
     * @param Comp $comp
     * @param  int $id
     * @return Response
     */
    public function show(Comment $comment ,Comp $comp , $id)
    {
        $comp = $comp->whereId($id)->with('user')->first();
        $comments = $comment->whereCompId($comp->id)
            ->whereStatus('v')
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(5);
        return view('pages.show' , compact('comp' , 'comments'));
    }

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

    /**
     * Apstrādā ievadīto attēlu.
     * @param $request
     * @return mixed
     */
    private function saveImg($request)
    {
        $file = $request->file('header_img');
        $img = Image::make($file)->fit(610 , 140);
        $fileName = $request->get('title').'-'.$file->getClientOriginalName();
        $img->save('uploads/comp_headers/'.$fileName);
        $comp = $request->all();
        $comp['header_img'] = '/uploads/comp_headers/'.$fileName;
        return $comp;
    }

    /**
     * Konvertē youtube linku uz nepieciešamo (embed)
     * @param $request
     * @return mixed
     */
    private function youtubeConverter($request)
    {
        $request['preview_link'] = str_replace(['watch?v='], ['embed/'] , $request['preview_link']);
        return $request;
    }

}
