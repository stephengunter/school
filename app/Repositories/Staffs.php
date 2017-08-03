<?php

namespace App\Repositories;

use App\Staff;
use Carbon\Carbon;

class Staffs 
{

    public function getAll()
    {
         return Staff::where('removed',false);
    }
    public function activeStaffs()
    {
         return $this->getAll()->where('status',1);
    }
    public function unActiveStaffs()
    {
         return $this->getAll()->where('status','<',1);
    }
    public function trash()
    {
         return Staff::where('removed',true);

    }
    
    public function findOrFail($id)
    {
        return Staff::findOrFail($id); 
    }

    public function getById($id)
    {
        $staff=Staff::find($id);
        if(!$staff) return null;
        if($staff->removed) return null;
        return $staff;
    }
    
    public function delete($id,$updated_by)
    {
         $staff = Staff::findOrFail($id);
       
         $values=[
            'removed' => 1,
            'updated_by' => $updated_by
         ];
        
         $staff->update($values);
        
    }

    public function optionsConverting($staffList)
    {
        $options=[];
        foreach($staffList as $staff)
        {
            array_push($options,  $staff->toOption());
        }
        return $options;
    }
    
    
    
     

     

   
   
   

  
  
   
   
    
}