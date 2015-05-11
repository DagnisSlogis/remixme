<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Votable extends Model {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'votables';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['slug'];

    public function submition()
    {
        return $this->belongsTo('App\Submition');
    }

    public function voting()
    {
        return $this->belongsTo('App\Voting');
    }

    public function votes()
    {
        return $this->hasMany('App\Vote');
    }

}
