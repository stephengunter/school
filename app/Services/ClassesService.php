<?php

namespace App\Services;

use App\TPSync\GroupSync;
use App\Classes;

class ClassesService
{
    private function getClassByCode($code)
    {
        $code=strtolower($code);
        return Classes::where('code',$code)->first();
    }

    private function get_need_sync_list()
    {
        $all=GroupSync::orderBy('parent')->get();
        $need_sync_list=[];
        foreach($all as $record)
        {
            if(!is_numeric($record->code))
            {
               array_push($need_sync_list, $record);
            }
        }

        return $need_sync_list;
    }

    public function syncClasses()
    {
        $need_sync_list=$this->get_need_sync_list();
        if(count($need_sync_list))
        {
            foreach($need_sync_list as $record)
            {
                if($record->isdelete){
                   
                    $this->deleteClass($record);
                }else{
                    $exist=$this->getClassByCode($record->code);
                    if($exist){
                        $this->updateClass($exist,$record);
                    }else{
                       // return 'createClasses' . $record->code;
                        $this->createClass($record);
                    }
                }
            }

        }
    }

    private function deleteClass(GroupSync $record)
    {
        $exist=$this->getClassByCode($code);
        if($exist){
            $values=[
                'removed' => 1,
            ];
            
            $exist->update($values);
        }

    }

    
    private function createClass(GroupSync $record)
    {
        $parent_code=$record->parent;
        if($parent_code){
            $parent=$this->getClassByCode($parent_code);
            if(!$parent) return;
        }

        Classes::create([
            'name' => $record->name,
            'code' => $record->code,
            'parent' => $parent_code,
        ]);

    }
    private function updateClass(Classes $classes ,GroupSync $record)
    {
        $parent_code=$record->parent;
        if($parent_code){
            $parent=$this->classess->getByCode($parent_code);
            if(!$parent) return;
        }

        $classes->update([
            'name' => $record->name,
            'code' => $record->code,
            'parent' => $parent_code,
        ]);
       
    }

    
    
    
}