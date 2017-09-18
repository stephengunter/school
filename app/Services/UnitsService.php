<?php

namespace App\Services;

use App\Repositories\Units;
use App\TPSync\GroupSync;
use App\Unit;

class UnitsService
{
 
    public function __construct(Units  $units)
    {
        $this->units=$units;
    }

    private function get_need_sync_list()
    {
        $all=GroupSync::orderBy('parent')->get();
        $need_sync_list=[];
        foreach($all as $record)
        {
            if(is_numeric($record->code))
            {
               array_push($need_sync_list, $record);
            }
        }

        return $need_sync_list;
    }

    public function syncUnits()
    {
        $need_sync_list=$this->get_need_sync_list();
        if(count($need_sync_list))
        {
            foreach($need_sync_list as $record)
            {
                if($record->isdelete){
                    $this->deleteUnit($record);
                }else{
                    $exist=$this->units->getByCode($record->code);
                    if($exist){
                        $this->updateUnit($exist,$record);
                    }else{
                        $this->createUnit($record);
                    }
                }
            }

        }
    }

    private function deleteUnit(GroupSync $record)
    {
        $unit=$this->units->getByCode($record->code);
        if($unit){
            $values=[
                'removed' => 1,
            ];
            
            $unit->update($values);
        }

    }

    
    private function createUnit(GroupSync $record)
    {
        $parent_code=$record->parent;
        if($parent_code){
            $parent=$this->units->getByCode($parent_code);
            if(!$parent) return;
        }

        Unit::create([
            'name' => $record->name,
            'code' => $record->code,
            'parent' => $parent_code,
        ]);

    }
    private function updateUnit(Unit $unit ,GroupSync $record)
    {
        $parent_code=$record->parent;
        if($parent_code){
            $parent=$this->units->getByCode($parent_code);
            if(!$parent) return;
        }

        $unit->update([
            'name' => $record->name,
            'code' => $record->code,
            'parent' => $parent_code,
        ]);
       
    }

    
    
    
}