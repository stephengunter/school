<?php

namespace App\Repositories\Teamplus;

use DB;
use App\Department;
use App\DepartmentUpdateRecord;
use App\Teamplus\TPDepartment;
use App\Teamplus\TPDepartmentForSync;
use App\Support\Helper;
use Carbon\Carbon;

class Departments 
{
     public function syncDepartments()
     {
       
        $department=Department::find(1);
        $has_parent=(int)$department->parent;
        $parent_department=null;
        if($has_parent){
            $parent_department=Department::findOrFail($department->parent);
        }else{
            $parent_department=new Department(['name'=>'系所']);
        }

        $parent_department=TPDepartment::where('Name',$parent_department->name)->first();
       
          
         TPDepartmentForSync::create([
                    'Code'=> 'department_' . $department->id ,
                    'Name' => $department->name ,
                    'ParentCode' => $parent_department->Code,
                    'UpdateTime' =>Carbon::today(),
                    'SyncStatus' => 0,
                    'IsDelete' => false,
                 ]);

                 return 'done';
        //  $records=DepartmentUpdateRecord::where('status', 0 )->get();
        //  if(count($records)){
        //      foreach($records as $record){
        //          $action=strtolower($$record->action);
        //          if($action=='insert'){

        //          }else if($action=='update'){

        //          }else if($action=='delete'){

        //          }
        //      }
        //  }
     }

    
   
   
    
}