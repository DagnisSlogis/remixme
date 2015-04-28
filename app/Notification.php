<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model {

    protected $fillable   = ['user_id', 'type', 'subject', 'title', 'object_id', 'object_type'];

    public function getDates()
    {
        return ['created_at', 'updated_at'];
    }

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

    public function regarding($object)
    {
        if(is_object($object))
        {
            $this->object_id   = $object->id;
            $this->object_type = get_class($object);
        }
        return $this;
    }



    public function user()
    {
        return $this->belongsTo('App\User');
    }
}