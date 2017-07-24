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
            $item=[ 'text' => $department->name , 
                     'value' => $department->id , 
                 ];
            array_push($options,  $item);
        }
          return $options;
    }

    public function options()
    {
        $departments=$this->departments->getAll()
                                       ->where('active',true)
                                       ->where('parent',0)
                                       ->get(); 
        foreach ($departments as $department) {
              $department->getChildren();
        }

       
    }

     

     

   
   
   

  
  
   
   
    
}