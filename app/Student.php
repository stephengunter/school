<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
	protected $primaryKey = 'user_id';
    public function user()
	{
		 return $this->belongsTo('App\User');
	}

    public function canDeleteBy($user)
	{
        return $true;
	}
    public function canEditBy($user)
	{
        return $true;
	}
}
