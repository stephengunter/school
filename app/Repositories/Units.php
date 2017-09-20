<?php

namespace App\Repositories;

use App\Unit;
use Carbon\Carbon;

class Units 
{
    public function getAll()
    {
         return Unit::where('removed',false);
    }
    public function trash()
    {
         return Unit::where('removed',true)
                            ->orderBy('updated_at','desc');

    }

    public function getByCode($code)
    {
        $code=strtolower($code);
        return Unit::where('code',$code)->first();
    }

    public function getTree()
    {
        $units=$this->getAll()
            ->where('code','!=', '102000')
            ->where('active',true)
            ->where('parent',0)
            ->orderBy('order','desc')
            ->orderBy('updated_at','desc')
            ->get();  
        if(count($units)){
            foreach ($units as $unit) {
               $unit->getChildren();
            }
        }

        return $units;
    }
    
    public function findOrFail($id)
    {
        return Unit::findOrFail($id); 
    }

    public function getById($id)
    {
        $unit=Unit::find($id);
        if(!$unit) return null;
        if($unit->removed) return null;
        return $unit;
    }
    public function updateDisplayOrder($unit ,$up,$updated_by)
    {
            $num= rand(1, 10);
            if($up){
                $unit->order += $num;
            }else{
                $unit->order -= $num;
            }

            $unit->updated_by=$updated_by;
            
            $unit->save();
           
            return $unit;

    }
    public function delete($id,$updated_by)
    {
         $unit = Unit::findOrFail($id);
       
         $values=[
            'removed' => 1,
            'updated_by' => $updated_by
         ];
        
         $unit->update($values);
        
    }

    public function optionsConverting($unitList)
    {
        $options=[];
        foreach($unitList as $unit)
        {
            array_push($options,  $unit->toOption());
        }
        return $options;
    }
    public function rootUnits()
    {
         return $this->getAll()->where('active',true)
                               ->where('parent',0);                     
    }
    public function options()
    {
        $units=$this->rootUnits()->get(); 
        foreach ($units as $unit) {
            $unit->getChildren();
            
        }

        
        return $this->optionsConverting($units);
       
    }

    public function getChildrenIds($id)
    {
        $children=$this->getAll()->where('parent',$id)->get()->pluck('id')->toArray();
        if($children){
            $ids=$children;
            for($i = 0; $i < count($children); ++$i){
                $ids=array_merge($this->getChildrenIds($children[$i]),$ids);
            }
            return $ids;
        }else{
            return [];
        }
    }
    
     

     

   
   
   

  
  
   
   
    
}