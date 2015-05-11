<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Winner extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'winners';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['place'];

    public function voting()
    {
        return $this->belongsTo('App\Voting');
    }
    public function submition()
    {
        return $this->belongsTo('App\Submition');
    }


}
