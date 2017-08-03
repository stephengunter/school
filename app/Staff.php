<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $primaryKey = 'user_id';
    
    public function user() 
    {
		 return $this->belongsTo('App\User');
    }
    public function unit() 
    {
		 return $this->belongsTo('App\Unit');
    }
    public function getName()
	{
        $this->name=$this->user->profile->fullname;
		return $this->name;
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
