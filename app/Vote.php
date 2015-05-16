<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'votes';

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function submition()
    {
        return $this->belongsTo('App\Submition');
    }

}
