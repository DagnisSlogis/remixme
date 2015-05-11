<?php namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Comp extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'comps';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title', 'preview_type', 'voting_type' , 'preview_link' , 'stem_link' , 'subm_end_date', 'comp_end_date',
        'header_img' , 'song_title' , 'genre' , 'bpm' , 'description' , 'rules' , 'prizes' , 'url' , 'facebook' , 'twitter'];

    protected $dates = ['comp_end_date' , 'subm_end_date'];
    /**
     * Adding full timestamp
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
     * A comp author is one user.
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
     * Polimorfiskā attiecība ar tabulu Notifications
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function notifications()
    {
        return $this->hasMany('App\Notification');
    }

    public function submitions()
    {
        return $this->hasMany('App\Submition')->orderBy('created_at' , 'desc');
    }

    public function voting()
    {
        return $this->hasOne('App\Voting');
    }
}
