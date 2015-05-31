<?php namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Comp extends Model {

    /**
     * Datubāzes tabula ko izmanto modulis
     *
     * @var string
     */
    protected $table = 'comps';

    /**
     * Tabulas atribūti kurus var - mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'preview_type', 'voting_type' , 'preview_link' , 'stem_link' ,
        'subm_end_date', 'comp_end_date', 'header_img' , 'song_title' , 'genre' , 'bpm' ,
        'description' , 'rules' , 'prizes' , 'url' , 'facebook' , 'twitter'];

    /**
     * Pārveido par laravel izmantoto timestamp
     *
     * @var array
     */
    protected $dates = ['comp_end_date' , 'subm_end_date'];


    /**
     * Pievieno pilnu timstamp
     * @param $date
     */
    public function setSubmEndDateAttribute($date)
    {
        $this->attributes['subm_end_date'] = Carbon::parse($date);
    }

    public function setCompEndDateAttribute($date)
    {
        $this->attributes['comp_end_date'] = Carbon::parse($date);
    }


    /**
     * Saskaita aktīvos komentārus
     *
     * @return int
     */
    public function commentcount()
    {
        return count($this->comments()->whereStatus('v')->get());
    }

    /**
     * Saskaita aktīvos iesūtītos remiksus
     *
     * @return int
     */
    public function entrycount()
    {
        return $this->submitions()->whereStatus('v')->count();

    }

    /**
     * Atgriež konkursa uzvarētāju skaitu
     *
     * @return mixed
     */
    public function winnercount()
    {
        return $this->voting->winners()->count();
    }

    /**
     * Konkursa autors ir viens lietotājs
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Konkursam ir daudz komentāru
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    /**
     * Konkurss var būt pievienots vairākas reizes kā favorīts
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function favorite()
    {
        return $this->hasMany('App\Favorite');
    }

    /**
     * Konkurss var būt daļa no daudziem paziņojumiem
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function notifications()
    {
        return $this->hasMany('App\Notification');
    }

    /**
     * Konkursam ir iesūtīto dziesmu
     *
     * @return mixed
     */
    public function submitions()
    {
        return $this->hasMany('App\Submition')->where('status', 'v')->orderBy('votes' , 'desc');
    }

    /**
     * Par konkursu notiek viena balsošana
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function voting()
    {
        return $this->hasOne('App\Voting');
    }
}
