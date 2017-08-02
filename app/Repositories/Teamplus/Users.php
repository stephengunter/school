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
use Excel;

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

    
    private function syncUserFromStudent(Student $student, $action)
    {
        $tp_department=$this->getTPDepartmentByName($student->department->name);
        
        $values= $this-> initializeValues($student->user,$action);
        $values['LoginAccount']=$student->number;
        $values['EmpID']=$student->number;
        $values['Name']=$student->getName();
        $values['DeptCode']=$tp_department->Code;
        
        TPUserForSync::create($values);
    }

    
    private function getTPDepartmentByName($name)
    {
         return TPDepartment::where('Name',$name)->first();
    }
    private function initializeValues(User $user,$action)
    {
        $values=TPUserForSync::initialize();
        $values['Email']=$user->email;

        $action=strtolower($action);
        if($action=='delete'){
            $values['IsDelete']=true;
        }else if($action=='insert'){
            $values['Password']=$this->defaultPassword($student->user);
        }else if($action=='stop'){
            $values['Status']==2;
        }else if($action=='leave'){
            $values['Status']==2;
        }
        
        return $values;
    }

    private function defaultPassword($user)
    {
          return '0000';
    }


    public function exportExcel()
    {
         Excel::create('Laravel Excel', function($excel) {

            $excel->sheet('Excel sheet', function($sheet) {

                $sheet->setOrientation('landscape');

            });

        })->export('xls');
    }

     

    
   
   
    
}