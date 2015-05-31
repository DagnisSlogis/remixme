<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Submition extends Model
{

    /**
     * Datubāzes tabula ko izmanto modulis
     *
     * @var string
     */
    protected $table = 'submitions';

    /**
     * Tabulas atribūti kurus var - mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'link', 'status'];

    /**
     * Vai ir aktīvs
     *
     * @return bool
     */
    public function active()
    {
        return ($this->status == 'v');
    }

    /**
     * Dziesma/remiks pieder lietotājam
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Dziesma/remiks pieder konkursam
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function comp()
    {
        return $this->belongsTo('App\Comp');
    }

    /**
     * Dziesma var uzvarēt vienreiz
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function winner()
    {
        return $this->hasOne('App\Winner');
    }

    /**
     * Par dziesmu var tikts balsot daudzreiz
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function votes()
    {
        return $this->hasMany('App\Vote');
    }

    /**
     * Dziesma var ņemt dalību tikai vienā konkursa balsošanā
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function voting()
    {
        return $this->belongsTo('App\Voting');
    }

}
