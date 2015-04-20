<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Comp;
use Auth;
use App\Http\Requests\CreateCompRequest;
use Illuminate\Http\Request;

class CompController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
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
        $comp = Auth::user()->comps()->create($competition);
        return redirect('/');
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
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
    public function saveImg($request)
    {
        $file = $request->file('header_img');
        $fileName = $request->get('title').'-'.$file->getClientOriginalName();
        $file->move(public_path().'/uploads/comp_headers/', $fileName);
        $comp = $request->all();
        $comp['header_img'] = '/uploads/comp_headers/'.$fileName;
        return $comp;
    }

    /**
     * Konvertē youtube linku uz nepieciešamo (embed)
     * @param $request
     * @return mixed
     */
    public function youtubeConverter($request)
    {
        $request['preview_link'] = str_replace(['watch?v='], ['embed/'] , $request['preview_link']);
        return $request;
    }

}
