<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = ['name',  'order',
						    'active', 'removed','updated_by'
						  ];
    public static function initialize()
    {
         return [
			 'name' => '',
			 'removed' => 0,
			 'updated_by' => '',
			 'order' => 0,
			 
        ];
    }
    public function departments()
    {
        return $this->belongsToMany('App\Department','grade_department');
    }
    public function toOption()
	{
		return [ 'text' => $this->name , 
                 'value' => $this->id , 
               ];
	}
    public function canViewBy($user)
	{
		return true;
	}
	public function canEditBy($user)
	{
		return true;
	}
	public function canDeleteBy($user)
	{
		if($this->removed)  return false;
		return true;

		if(!$this->canEditBy($user)) return false;

		
		return true;
	}
}
