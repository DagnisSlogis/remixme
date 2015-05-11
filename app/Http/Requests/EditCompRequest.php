<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use Auth;

class EditCompRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
        if(Auth::user())
        {
            return true;
        }
        return abort(403, 'Jūs neesat pieslēdzies.');
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
            'genre' => 'min:5|max:30',
            'bpm' => 'min:5|max:30',
        ];
	}

}
