<?php

namespace App\Repositories\Teamplus;

use DB;
use App\Department;
use App\Classes;
use App\Unit;
use App\Teamplus\DepartmentUpdateRecord;
use App\Teamplus\TPDepartment;
use App\Teamplus\TPDepartmentForSync;
use App\Support\Helper;
use Carbon\Carbon;

class Departments 
{
    public function syncDepartments()
    {
        
        $records=DepartmentUpdateRecord::where('done', false )->get();
        foreach($records as $record){
               $parent_code='';
               $parent_checked=true;
               if($record->parent){
                   $parent_department=TPDepartment::where('Name',$record->parent)->first();
                   if($parent_department) $parent_code=$parent_department->Code;
                   else $parent_checked=false;
               }
               if($parent_checked){
                    $code=$record->getCode();
                    $name=$record->name;
                    $delete=$record->delete;
                    $saved= $this->syncDepartment($name, $code,$parent_code,$delete);
                    if($saved){
                       $record->done=true;
                       $record->save();
                    }
                    
               }
               
        }
        
    }
   
    public function syncDepartment($name, $code,$parent_code,$delete)
    {
        $values=TPDepartmentForSync::initialize();
        $values['Name']=$name;
        $values['Code']=$code;
        $values['ParentCode']=$parent_code;
        $values['IsDelete']=$delete;
        
        return $this->saveDepartmentForSync($values);
    }
    private function saveDepartmentForSync($values)
    {
        $exist_record=$this->existDepartmentForSync($values['Name']);
        if($exist_record){
           return  $exist_record->update($values);
        }else{
           return TPDepartmentForSync::create($values);
        }
    }
    
    public function existDepartmentForSync($name)
    {
          return TPDepartmentForSync::where('SyncStatus',0)
                             ->where('Name',$name)->first();
    }
    public function getTPDepartmentByName($name)
    {
         return TPDepartment::where('Name',$name)->first();
    }
    
}