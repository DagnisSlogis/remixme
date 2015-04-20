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
        'header_img' , 'song_title' , 'genre' , 'bpm' , 'description' , 'rules' , 'prizes' , 'url' , 'facebook' , 'twitter' , 'author_id'];

    protected $dates = ['comp_end_date'];
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
     * A comp author is one user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo('App\User');
    }
}
