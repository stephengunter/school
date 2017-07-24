<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public function jobPositions() 
	{
		return $this->hasMany(JobPosition::class);
	}

	public function getParent()
	{
		$this->parentDepartment=static::find($this->parent);
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
		$children=static::where('removed',false)
								->where('parent',$this->id)
								->get();

		if(count($children)){
             foreach ($children as $department) {
                $department->getChildren();
            }
        }

		$this->children= $children;
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
		return true;

		if(!$this->canEditBy($user)) return false;

		if(count($this->roles)){
			return false;
		}
		return true;
	}
}
