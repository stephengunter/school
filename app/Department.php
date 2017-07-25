<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
	protected $fillable = ['name', 'code', 'parent', 'description',
							// 'order','icon',
						    'active', 'removed','updated_by'
						  ];
    public function jobPositions() 
	{
		return $this->hasMany(JobPosition::class);
	}

	public function getParent()
	{
		$this->parentDepartment=static::find($this->parent);
		return $this->parentDepartment;
	}

	public function getParents()
	{
		if(!$this->parent){
			$this->parentDepartment=null;
			return ;
		}
		$parentDepartment=static::find($this->parent);
		$hasParent=$parentDepartment->parent > 0;
		$parents = collect([$parentDepartment]);
		
		while ($hasParent) {
			$parentDepartment=static::find($parentDepartment->parent);
			$parents->push($parentDepartment);
			$hasParent=$parentDepartment->parent > 0;
		}

		$this->parentDepartment=$parents;
	}

	public function getChildren(){
		$children=$this->childs();

		if(count($children)){
            foreach ($children as $department) {
                $department->getChildren();
            }
        }

		$this->children= $children;
		
	}
	public function childs()
	{
		return static::where('removed',false)
					  ->where('parent',$this->id)
					  ->get();
	}
	public function toOption()
	{
		$childrenOptions=[];
		if(count($this->children)){
			foreach ($this->children as $department) {
				array_push($childrenOptions,  $department->toOption());
       		}
		}
		return [ 'text' => $this->name , 
                 'value' => $this->id , 
				 'childrenOptions' => $childrenOptions
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

		if(count($this->roles)){
			return false;
		}
		return true;
	}
}
