<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobPosition extends Model
{
    public function department() 
    {
		return $this->belongsTo('App\Department');
	}
    public function staff()
	{
		return $this->hasOne(Staff::class);
	}
}
