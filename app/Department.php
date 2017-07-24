<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public function jobPositions() {
		return $this->hasMany(JobPosition::class);
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
}
