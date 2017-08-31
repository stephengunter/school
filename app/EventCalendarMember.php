<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventCalendarMember extends Model
{
    protected $table = 'event_calendar_members';
    protected $fillable = [ 'event_id', 'tp_id','member'  ];

    
    public function user()
    {
	    return $this->belongsTo('App\EventCalendar','event_id');
	}
                         
}
