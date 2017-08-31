<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventCalendar extends Model
{
    protected $table = 'event_calendars';
    protected $fillable = [ 'code', 'name', 'description',
						    'start_time', 'end_time', 'removed'
                          ];


    public function members()
    {
        return $this->hasMany(EventCalendarMember::class, 'event_id');
    }                      
                          
}
