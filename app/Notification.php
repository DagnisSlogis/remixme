<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model {

    /**
     * Tabulas atribūti kurus var - mass assignable.
     *
     * @var array
     */
    protected $fillable   = ['user_id', 'type', 'subject', 'title', 'object_id', 'object_type'];


    /**
     * Datumu pārveidošana par timstamp
     *
     * @return array
     */
    public function getDates()
    {
        return ['created_at', 'updated_at' , 'subm_end_date' , 'end_date' , 'show_date'];
    }

// Notification izveidošanas funkcijas

    public function withSubject($subject)
    {
        $this->subject = $subject;
        return $this;
    }

    public function withTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function withType($type)
    {
        $this->type = $type;
        return $this;
    }

    public function withShowDate($show_date)
    {
        $this->show_date = $show_date;
        return $this;
    }
    public function withComp($id)
    {
        $this->comp_id = $id;
        return $this;
    }

//***


    /**
     * Paziņojums pieder lietotājam
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Paziņojums pieder konkursam
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function comp()
    {
        return $this->belongsTo('App\Comp');
    }
}