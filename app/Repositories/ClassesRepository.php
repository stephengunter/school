<?php

namespace App\Repositories;

use App\Classes;
use Carbon\Carbon;

class ClassesRepository 
{
    public function getAll()
    {
         return Classes::where('removed',false);
    }
    public function activeClasses($department_id)
    {
         return $this->getAll()->where('department_id',$department_id)
                                ->where('active',true);
    }
    public function unActiveClasses($department_id)
    {
          return $this->getAll()->where('department_id',$department_id)
                                ->where('active',false);
    }
    public function trash()
    {
         return Classes::where('removed',true)
                            ->orderBy('updated_at','desc');

    }
    
    public function findOrFail($id)
    {
        return Classes::findOrFail($id); 
    }

    public function getById($id)
    {
        $entity=Classes::find($id);
        if(!$entity) return null;
        if($entity->removed) return null;
        return $entity;
    }
    public function updateDisplayOrder($entity ,$up,$updated_by)
    {
            $num= rand(1, 10);
            if($up){
                $entity->order += $num;
            }else{
                $entity->order -= $num;
            }

            $entity->updated_by=$updated_by;
            
            $entity->save();
           
            return $entity;

    }
    public function delete($id,$updated_by)
    {
         $entity = Classes::findOrFail($id);
       
         $values=[
            'removed' => 1,
            'updated_by' => $updated_by
         ];
        
         $entity->update($values);
        
    }

    public function optionsConverting($entityList)
    {
        $options=[];
        foreach($entityList as $entity)
        {
            array_push($options,  $entity->toOption());
        }
        return $options;
    }
    
    
    
     

     

   
   
   

  
  
   
   
    
}