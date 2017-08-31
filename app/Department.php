<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
	protected $fillable = ['name','en_name' ,'code', 'parent', 'description',
							
						    'active', 'removed','updated_by'
						  ];
	public static function initialize()
    {
         return [
			 'name' => '',
			 'code' => '',
			 'parent' => 0,
			 'description' => '',
			 
			 'active' => 1,
			 'removed' => 0,
			 'updated_by' => '',

			 'order' => 0,
			 'icon' => ''
			 
        ];
    }						  
    public function classes() 
	{
		return $this->hasMany('App\Classes');
	}
    public function grades()
    {
        return $this->belongsToMany('App\Grade','grade_department');
    }
	public function parentDepartment()
    {
		$parentId=(int)$this->parent;
		if($parentId)  return static::find($parentId);
		return null;
       
    }
	public function parentName()
    {
		$parent_department=$this->parentDepartment();
		if($parent_department)  return $parent_department->name;
		return '';
       
    }
	public function parentCode()
    {
		$parent_department=$this->parentDepartment();
		if($parent_department)  return $parent_department->code;
		return '';
       
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
