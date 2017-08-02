<?php

namespace App\Repositories;

use App\Classes;
use App\Grade;
use Carbon\Carbon;

class ClassesRepository 
{
    public function getAll()
    {
         return Classes::where('removed',false);
    }
    private function departmentActiveClasses(int $department_id){
          return $this->getAll()->where('department_id',$department_id)
                                ->where('active',true);
    }
    public function activeClasses(int $department_id, int $grade_id=0)
    {
        if($grade_id){
            return $this->departmentActiveClasses($department_id)
                        ->where('grade_id',$grade_id)
                        ->orderBy('order')
                        ->with('grade')
                        ->get(); 
        }

        $distinct_grade=$this->departmentActiveClasses($department_id)
                                        ->distinct()->get(['grade_id'])->toArray();

                                      
        $distinct_grade_ids=array_pluck($distinct_grade, 'grade_id');
       
        $grades=Grade::whereIn('id',$distinct_grade_ids)
                               ->orderBy('order')->get();
          
        $classList=collect([]);

        if(count($grades)){
            for($i = 0; $i < count($grades); ++$i) {
                $grade_id=$grades[$i]->id;
                $classList = $classList->merge($this->departmentActiveClasses($department_id)
                                                    ->where('grade_id',$grade_id)
                                                    ->orderBy('order')
                                                    ->with('grade')
                                                    ->get() 
                                            );

                   
            }
        }

        
        

        return $classList;

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
                $entity->order -= $num;
            }else{
                $entity->order += $num;
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
    public function options(int $department_id, int $grade_id=0)
    {
        $activeClasses=$this->activeClasses($department_id, $grade_id);
       
        return $$this->optionsConverting($activeClasses);
    }
    
    
    
     

     

   
   
   

  
  
   
   
    
}