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
    public function activeDepartments()
    {
         return $this->getAll()->where('active',true);
    }
    public function unActiveDepartments()
    {
         return $this->getAll()->where('active',false);
    }
    public function trash()
    {
         return Department::where('removed',true)
                            ->orderBy('updated_at','desc');

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
    public function updateDisplayOrder($department ,$up,$updated_by)
    {
            $num= rand(1, 10);
            if($up){
                $department->order += $num;
            }else{
                $department->order -= $num;
            }

            $department->updated_by=$updated_by;
            
            $department->save();
           
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
    
    public function options()
    {
        $departments=$this->activeDepartments()->get(); 
        return $this->optionsConverting($departments);
       
    }
    
     

     

   
   
   

  
  
   
   
    
}