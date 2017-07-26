<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $table = 'classes';
    protected $fillable = ['name',
						    'active', 'removed','updated_by'
						  ];
    public static function initialize($department_id)
    {
         return [
			 'name' => '',
			 'department_id' => $department_id,
			 
			 'active' => 1,
			 'removed' => 0,
			 'updated_by' => '',

			 'order' => 0,
			 
        ];
    }
    public function department() 
	{
		return $this->belongsTo('App\Department');
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
