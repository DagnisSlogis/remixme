<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['username', 'email', 'password' , 'profile_img' , 'facebook'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

    //Funkcijas
    /**
     * @return bool
     */
    public function isAdmin() {
        return ($this->status == 2);
    }

    public function isOwner($comp)
    {
        return ($this->id == $comp->user_id);
    }

    public function newNotification()
    {
        $notification = new Notification;
        $notification->user()->associate($this);

        return $notification;
    }



    // Saistības starp tabulām
    /**
     * User can have many comps
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

    public function notifications()
    {
        return $this->hasMany('App\Notification');
    }

    public function submitions()
    {
        return $this->hasMany('App\Submition');
    }

    public function votes()
    {
        return $this->hasMany('App\Vote');
    }
}

