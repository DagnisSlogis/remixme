<?php namespace App\Services;

use App\User;
use Validator;
use Illuminate\Contracts\Auth\Registrar as RegistrarContract;

class Registrar implements RegistrarContract {

	/**
	 * Validē ievadītos reģistrācija datus
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator(array $data)
	{
		return Validator::make($data, [
			'username' => 'required|min:4|max:255|unique:users',
			'email' => 'required|email|min:5|max:255|unique:users',
            'profile_img_link' => 'image|max:1000|mimes:jpeg,png',
			'password' => 'required|confirmed|min:8',
		]);
	}

	/**
	 * Izveido jaunu lietotāju datubāzē, ja validēšana notikusi veiksmīgi
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function create(array $data )
	{
        $filename = $this->getImgName($data);
        \Session::flash('success_message', 'Reģistrācija ir notikusi veiksmīgi!');
		return User::create([
			'username' => $data['username'],
			'email' => $data['email'],
			'password' => bcrypt($data['password']),
			'profile_img' => $filename,
			'facebook' => $data['facebook'],
		]);
	}

    /**
     * Pārbauda vai lietotājs ir augšupielādējis bildi, ja nav bilde = noklusētā
     *
     * @param array $data
     * @return string
     */
    private function getImgName(array $data)
    {
        if($data['profile_img_link']){
            $filename = '/uploads/'.$data['username'].'-'.$data['profile_img_link']->getClientOriginalName();
        }
        else {
            $filename = '/img/noImg.jpg';
        }
        return $filename;
    }

}
