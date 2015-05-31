<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model {

    /**
     * Datubāzes tabula ko izmanto modulis
     *
     * @var string
     */
    protected $table = 'favorites';


    /**
     * Favorīts pieder lietotājam
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Favorīts pieder konkursam
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function comp()
    {
        return $this->belongsTo('App\Comp');
    }

}
