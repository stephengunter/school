<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Support\FilterPaginateOrder;

class Student extends Model
{
	use FilterPaginateOrder;
	protected $filter =  [ 'user.profile.fullname',  'number','active'
                         ];

	protected $primaryKey = 'user_id';
    public function user()
	{
		 return $this->belongsTo('App\User');
	}
	public function department()
	{
		 return $this->belongsTo('App\Department');
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
