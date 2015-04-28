<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use Auth;

class AddCommentRequest extends Request {

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
            'text' => 'required',
		];
	}

}
