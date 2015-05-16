<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Submition extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'submitions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'link', 'status'];

    public function active()
    {
        return ($this->status == 'v');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function comp()
    {
        return $this->belongsTo('App\Comp');
    }


    public function winner()
    {
        return $this->hasOne('App\Winner');
    }
    public function votes()
    {
        return $this->hasMany('App\Vote');
    }
    public function voting()
    {
        return $this->belongsTo('App\Voting');
    }

}
