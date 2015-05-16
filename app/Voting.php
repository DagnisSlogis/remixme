<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Voting extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'votings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['show_date'];

    public function submitions()
    {
        return $this->hasMany('App\Submition');
    }

    public function comp()
    {
        return $this->belongsTo('App\Comp');
    }

    public function winners()
    {
        return $this->hasMany('App\Winner');
    }
}
