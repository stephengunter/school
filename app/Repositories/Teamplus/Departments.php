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

class Departments 
{
    public function syncDepartments()
    {
        $records=DepartmentUpdateRecord::where('done', false )->get();
        foreach($records as $record){
               $parent_code='';
               if($record->parent){
                   $parent_department=TPDepartment::where('Name',$record->parent)->first();
                   $parent_code=$parent_department->Code;
               }
               $code='department_' . $record->department_id;
               $name=$record->name;
               $delete=$record->delete;
               $this->syncDepartment($name, $code,$parent_code,$delete);

               $record->done=true;
               $record->save();
        }
        
    }
   
    public function syncDepartment($name, $code,$parent_code,$delete)
    {
        $values=TPDepartmentForSync::initialize();
        $values['Name']=$name;
        $values['Code']=$code;
        $values['ParentCode']=$parent_code;
        $values['IsDelete']=$delete;
        
        $this->saveDepartmentForSync($values);
    }
    private function saveDepartmentForSync($values)
    {
        $exist_record=$this->existDepartmentForSync($values['Name']);
        if($exist_record){
            $exist_record->update($values);
        }else{
            TPDepartmentForSync::create($values);
        }
    }
    
    public function existDepartmentForSync($name)
    {
          return TPDepartmentForSync::where('SyncStatus',0)
                             ->where('Name',$name)->first();
    }
    
}