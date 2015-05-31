<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * Datubāzes tabula ko izmanto modulis
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * Tabulas atribūti kurus var - mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['username', 'email', 'password' , 'profile_img' , 'facebook'];

	/**
	 * Atribūti kas netiek iekļauti JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];


    /**
     * Vai ir administrators
     *
     * @return bool
     */
    public function isAdmin() {
        return ($this->status == 2);
    }

    /**
     * Vai ir konkursa īpašnieks
     * @param $comp
     * @return bool
     */
    public function isOwner($comp)
    {
        return ($this->id == $comp->user_id);
    }

    /**
     * Asocē lietotāju ar paziņojumu
     *
     * @return Notification
     */
    public function newNotification()
    {
        $notification = new Notification;
        $notification->user()->associate($this);

        return $notification;
    }

    /**
     * Lietotājam var būt vairāki konkursi
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comps()
    {
        return $this->hasMany('App\Comp');
    }

    /**
     * Lietotājs var rakstīt vairākus komentārus
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    /**
     * Lietotājam var būt vairāki favorīti
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function favorite()
    {
        return $this->hasMany('App\Favorite');
    }

    /**
     * Lietotājam var būt vairāki paziņojumi
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notifications()
    {
        return $this->hasMany('App\Notification');
    }

    /**
     * Lietotājs var iesūtīt vairākas dziesmas.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function submitions()
    {
        return $this->hasMany('App\Submition');
    }

    /**
     * Lietotājam var būt vairākas balsis.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function votes()
    {
        return $this->hasMany('App\Vote');
    }
}

