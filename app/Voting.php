<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Voting extends Model {

    /**
     * Datubāzes tabula ko izmanto modulis
     *
     * @var string
     */
    protected $table = 'votings';

    /**
     * Tabulas atribūti kurus var - mass assignable.
     *
     * @var array
     */
    protected $fillable = ['show_date'];

    /**
     * Balsošanā var tikt balsots par daudzām dziesmām
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function submitions()
    {
        return $this->hasMany('App\Submition');
    }

    /**
     * Viena balsošana ir saistīta ar vienu konkursu
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function comp()
    {
        return $this->belongsTo('App\Comp');
    }

    /**
     * Balsošana var dot vairākus uzvarētājus ( līdz 3)
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function winners()
    {
        return $this->hasMany('App\Winner');
    }
}
