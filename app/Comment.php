<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

    /**
     * Datubāzes tabula ko izmanto modulis
     *
     * @var string
     */
    protected $table = 'comments';

    /**
     * Tabulas atribūti kurus var - mass assignable.
     *
     * @var array
     */
    protected $fillable = ['text'];

    /**
     * Komentārs pieder vienam lietotājam
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Komentārs pieder vienam konkursam
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function comp()
    {
        return $this->belongsTo('App\Comp');
    }
}
