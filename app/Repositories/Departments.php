<?php

namespace App\Repositories;

use App\Department;
use Carbon\Carbon;

class Departments 
{
    public function getAll()
    {
         return Department::where('removed',false);
    }
    
    public function findOrFail($id)
    {
        return Department::findOrFail($id); 
    }

    public function getById($id)
    {
        $department=Department::find($id);
        if(!$department) return null;
        if($department->removed) return null;
        return $department;
    }

    public function delete($id,$updated_by)
    {
         $department = Department::findOrFail($id);
       
         $values=[
           
            'removed' => 1,
            'updated_by' => $updated_by
         ];
        
         $department->update($values);
        
    }

    public function optionsConverting($departmentList)
    {
        $options=[];
        foreach($departmentList as $department)
        {
            array_push($options,  $department->toOption());
        }
        return $options;
    }
    public function rootDepartments()
    {
         return $this->getAll()->where('active',true)
                               ->where('parent',0);                     
    }
    public function options()
    {
        $departments=$this->rootDepartments()->get(); 
        foreach ($departments as $department) {
            $department->getChildren();
            
        }

        
        return $this->optionsConverting($departments);
        // $department=  $departments[1];

        // $children = $department->childs();
        // $hasChildren=count($children) > 0; 
        // while ($hasChildren) {
        //     $parentDepartment=static::find($parentDepartment->parent);
        //     $parents->push($parentDepartment);
        //     $hasParent=$parentDepartment->parent > 0;
		// }
        // return $hasChildren;

       
        // foreach ($departments as $department) {
        //     $children = $department->childs();
        //     $hasChildren=count($children) > 0; 
        //     while ($hasChildren) {
        //         $parentDepartment=static::find($parentDepartment->parent);
        //         $parents->push($parentDepartment);
        //         $hasParent=$parentDepartment->parent > 0;
		//     }
        // }

        

        // $parentDepartment=static::find($this->parent);
		// $hasParent=$parentDepartment->parent > 0;
		// $parents = collect([$parentDepartment]);
		
		// while ($hasParent) {
		// 	$parentDepartment=static::find($parentDepartment->parent);
		// 	$parents->push($parentDepartment);
		// 	$hasParent=$parentDepartment->parent > 0;
		// }

		// $this->parentDepartment=$parents;

       
    }
    
     

     

   
   
   

  
  
   
   
    
}