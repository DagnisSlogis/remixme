<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Winner extends Model {

    /**
     * Datubāzes tabula ko izmanto modulis
     *
     * @var string
     */
    protected $table = 'winners';

    /**
     * Tabulas atribūti kurus var - mass assignable.
     *
     * @var array
     */
    protected $fillable = ['place'];

    /**
     * Uzvarētājs ir tikts noskaidrots vienā balsošanā.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function voting()
    {
        return $this->belongsTo('App\Voting');
    }

    /**
     * Uzvara iegūta ar vienu dziesmu
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function submition()
    {
        return $this->belongsTo('App\Submition');
    }


}
