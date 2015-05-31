<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model {

    /**
     * Datubāzes tabula ko izmanto modulis
     *
     * @var string
     */
    protected $table = 'votes';

    /**
     * Balss pieder lietotājam
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Balss var tikt atdota par dziesmu
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function submition()
    {
        return $this->belongsTo('App\Submition');
    }

}
