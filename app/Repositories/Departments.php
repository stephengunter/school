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

     

     

   
   
   

  
  
   
   
    
}