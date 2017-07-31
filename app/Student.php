<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Support\FilterPaginateOrder;

class Student extends Model
{
	use FilterPaginateOrder;
	protected $fillable = [ 'ps', 'join_date',
						    'active', 'removed','updated_by'
						  ];
	protected $filter =  [ 'user.profile.fullname',  'number','active'
                         ];

	protected $primaryKey = 'user_id';

	public static function createNumber()
	{
       return mt_rand(1061000, 1069999);
	}

    public function user()
	{
		 return $this->belongsTo('App\User');
	}
	public function department()
	{
		 return $this->belongsTo('App\Department');
	}
	public function class()
	{
		 return $this->belongsTo('App\Classes','class_id');
	}
	public function getName()
	{
        $this->name=$this->user->profile->fullname;
		return $this->name;
	}
	public function canViewBy($user)
	{
        return true;
	}
    public function canDeleteBy($user)
	{
        return true;
	}
    public function canEditBy($user)
	{
        return true;
	}
}
