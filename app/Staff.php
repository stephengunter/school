<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Support\FilterPaginateOrder;

class Staff extends Model
{
    use FilterPaginateOrder;

    protected $primaryKey = 'user_id';

    protected $fillable = [ 'ps', 'join_date', 'unit_id',
						    'status', 'removed','updated_by'
						  ];
	protected $filter =  [ 'user.profile.fullname',  'number','status'
                         ];
    
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
