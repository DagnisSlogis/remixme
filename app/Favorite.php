<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'favorites';

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function comp()
    {
        return $this->belongsTo('App\Comp');
    }

}
