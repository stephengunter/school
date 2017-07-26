<?php

namespace App\Repositories;

use App\Student;
use Carbon\Carbon;

class Students 
{
    public function getAll()
    {
         return Student::where('removed',false);
    }
    public function activeStudents()
    {
         return $this->getAll()->where('active',true);
    }
    public function unActiveStudents()
    {
         return $this->getAll()->where('active',false);
    }
    public function trash()
    {
         return Student::where('removed',true)
                            ->orderBy('updated_at','desc');

    }
    
    public function findOrFail($id)
    {
        return Student::findOrFail($id); 
    }

    public function getById($id)
    {
        $student=Student::find($id);
        if(!$student) return null;
        if($student->removed) return null;
        return $student;
    }
    
    public function delete($id,$updated_by)
    {
         $student = Student::findOrFail($id);
       
         $values=[
            'removed' => 1,
            'updated_by' => $updated_by
         ];
        
         $student->update($values);
        
    }

    public function optionsConverting($studentList)
    {
        $options=[];
        foreach($studentList as $student)
        {
            array_push($options,  $student->toOption());
        }
        return $options;
    }
    
    
    
     

     

   
   
   

  
  
   
   
    
}