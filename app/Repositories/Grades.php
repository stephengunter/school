<?php

namespace App\Repositories;

use App\Grade;
use Carbon\Carbon;

class Grades 
{
    public function getAll()
    {
         return Grade::where('removed',false);
    }
    
    public function trash()
    {
         return Grade::where('removed',true)
                            ->orderBy('updated_at','desc');

    }
    
    public function findOrFail($id)
    {
        return Grade::findOrFail($id); 
    }

    public function getById($id)
    {
        $grade=Grade::find($id);
        if(!$grade) return null;
        if($grade->removed) return null;
        return $grade;
    }
    public function updateDisplayOrder($grade ,$up,$updated_by)
    {
            $num= rand(1, 10);
            if($up){
                $grade->order += $num;
            }else{
                $grade->order -= $num;
            }

            $grade->updated_by=$updated_by;
            
            $grade->save();
           
            return $grade;

    }
    public function delete($id,$updated_by)
    {
         $grade = Grade::findOrFail($id);
       
         $values=[
            'removed' => 1,
            'updated_by' => $updated_by
         ];
        
         $grade->update($values);
        
    }

    public function optionsConverting($gradeList)
    {
        $options=[];
        foreach($gradeList as $grade)
        {
            array_push($options,  $grade->toOption());
        }
        return $options;
    }
    
    
    
     

     

   
   
   

  
  
   
   
    
}