<?php namespace App\Http\Requests;
use Auth;
use App\Http\Requests\Request;

class CreateCompRequest extends Request {

	/**
	 * Pārbauda vai pieslēdzies
	 *
	 * @return bool
	 */
	public function authorize()
	{
        if(Auth::user())
        {
            return true;
        }
        return abort(403, 'Neatļauta darbība, pieslēdzieties.');
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
            'title' => 'required|min:5|max:100',
            'preview_type' => 'required',
            'preview_link' => 'required',
            'description' => 'required',
            'prizes' => 'required',
            'rules' => 'required',
            'header_img' => 'image|max:1000|mimes:jpeg,png',
            'subm_end_date' => 'required|date',
            'comp_end_date' => 'required|date',
            'song_title' => 'required|min:5|max:100',
            'stem_link' => 'required',
            'voting_type' => 'required',
            'genre' => 'min:5|max:30',
            'bpm' => 'min:5|max:30',
		];
	}

}
