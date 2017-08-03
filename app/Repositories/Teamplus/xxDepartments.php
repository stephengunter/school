<?php

namespace App\Repositories\Teamplus;

use DB;
use App\Department;
use App\Classes;
use App\Unit;
use App\DepartmentUpdateRecord;
use App\Teamplus\TPDepartment;
use App\Teamplus\TPDepartmentForSync;
use App\Support\Helper;
use Carbon\Carbon;

class xxDepartments 
{
    public function createDepartmentForSync(Department $department, $action)
    {
        $has_parent=(int)$department->parent;
        $parent_department=null;
        if($has_parent){
            $parent_department=Department::findOrFail($department->parent);
        }else{
            $parent_department=new Department(['name'=>'系所']);
        }
        $parent_department=$this->getTPDepartmentByName($parent_department->name);
        $is_delete=false; 
        if(strtolower($action)=='delete'){
            $is_delete=true;
        }

           TPDepartmentForSync::create([
                    'Code'=> 'department_' . $department->id ,
                    'Name' => $department->name ,
                    'ParentCode' => $parent_department->Code,
                    'UpdateTime' =>Carbon::today(),
                    'SyncStatus' => 0,
                    'IsDelete' => false,
                 ]);
    }
    public function createClassForSync(Classes $entity, $action)
    {
        $parent_department=$this->getTPDepartmentByName($entity->department->name);
        
        $is_delete=false; 
        if(strtolower($action)=='delete'){
            $is_delete=true;
        }

           TPDepartmentForSync::create([
                    'Code'=> 'class_' . $entity->id ,
                    'Name' => $entity->name ,
                    'ParentCode' => $parent_department->Code,
                    'UpdateTime' =>Carbon::today(),
                    'SyncStatus' => 0,
                    'IsDelete' => false,
                 ]);
    }
    public function createUnitForSync(Unit $unit, $action)
    {
        $has_parent=(int)$unit->parent;
        $parent_department=null;
        if($has_parent){
            $parent_department=Unit::findOrFail($unit->parent);
        }else{
            $parent_department=new Unit(['name'=>'部門']);
        }
        $parent_department=$this->getTPDepartmentByName($parent_department->name);
        $is_delete=false; 
        if(strtolower($action)=='delete'){
            $is_delete=true;
        }

           TPDepartmentForSync::create([
                    'Code'=> 'unit_' . $unit->id ,
                    'Name' => $unit->name ,
                    'ParentCode' => $parent_department->Code,
                    'UpdateTime' =>Carbon::today(),
                    'SyncStatus' => 0,
                    'IsDelete' => false,
                 ]);
    }
    public function syncDepartments()
    {
         $records=DepartmentUpdateRecord::where('status', 0 )->get();
         if(count($records)){
            foreach($records as $record){
                 $action=$record->action;
                 $department=Department::findOrFail($record->department_id);
                 $this->createDepartmentForSync($department, $action);
            }
         }
    }

    public function getTPDepartmentByName($name)
    {
         return TPDepartment::where('Name',$name)->first();
    }
    public function getAll()
    {
         return TPDepartment::all();
    }
    public function existDepartmentForSync($name)
    {
          return TPDepartmentForSync::where('SyncStatus',0)
                             ->where('Name',$name)->first();
    }
   
   
    
}