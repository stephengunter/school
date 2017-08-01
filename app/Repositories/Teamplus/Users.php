<?php

namespace App\Repositories\Teamplus;

use DB;
use App\User;
use App\Student;
use App\UserUpdateRecord;
use App\Teamplus\TPUser;
use App\Teamplus\TPUserForSync;
use App\Support\Helper;
use Carbon\Carbon;

class Users 
{
     public function syncUsers()
     {
         $student=Student::find(1);
         $department_code='';
         TPUserForSync::create([
                    'LoginAccount'=>$student->number,
                    'EmpID'=>$student->number,
                    'Name' => $student->getName(),
                    'DeptCode' => $department_code,

                 ]);
         $records=UserUpdateRecord::where('status', 0 )->get();
         foreach($records as $record){
                $user_for_sync=null;
                $action=strtolower($record->action);
                $role=strtolower($record->role);
                if($role=='student'){
                    
                }else if($role=='staff'){

                }else if($role=='teacher'){

                }
                if($action=='insert'){

                }else if($action=='update'){

                }else if($action=='delete'){

                }
         }
     }


     private function syncUserFromStudent($user){
          $student=Student::findOrFail($user->id);
          $tp_department=TPDepartment::where('Name',$parent_department->name)->first();
          TPUserForSync::create([
                'LoginAccount'=>$student->number,
                'EmpID'=>$student->number,
                'Name' => $student->getName(),
                'DeptCode' => $this->getTPDepartmentCode($student->department->name),
                'JobTitle' => '',
                

          ]);
     }

     private function getTPDepartmentCode($name){
        $tp_department=TPDepartment::where('Name',$name)->first();
        return $tp_department->Code;
     }


     

    
   
   
    
}