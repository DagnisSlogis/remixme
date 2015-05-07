<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model {

    protected $fillable   = ['user_id', 'type', 'subject', 'title', 'object_id', 'object_type'];
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




    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function comp()
    {
        return $this->belongsTo('App\Comp');
    }
}