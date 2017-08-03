<?php

namespace App\Repositories\Teamplus;

use DB;
use App\User;
use App\Student;
use App\Staff;
use App\UserUpdateRecord;
use App\Teamplus\TPUser;
use App\Teamplus\TPDepartment;
use App\Teamplus\TPUserForSync;
use App\Support\Helper;
use Carbon\Carbon;
use Excel;

class Users 
{
     public function syncUsers()
     {
         $records=UserUpdateRecord::where('status', 0 )->get();
         foreach($records as $record){
                $user_id=$record->user_id;
                $action=$record->action;
                $role=strtolower($record->role);
                if($role=='student'){
                    $student=Student::findOrFail($user_id);
                    $this->syncUserFromStudent($student,$action);
                }else if($role=='staff'){

                }else if($role=='teacher'){

                }
                
         }
     }

    
    public function syncUserFromStudent(Student $student, $action)
    {
        $tp_department=$this->getTPDepartmentByName($student->class->name);
        
        $values= $this-> initializeValues($student->user,$action);
        $values['LoginAccount']=$student->number;
        $values['EmpID']=$student->number;
        $values['Name']=$student->getName();
        $values['DeptCode']=$tp_department->Code;
        
        TPUserForSync::create($values);
    }
    public function syncUserFromStaff(Staff $staff, $action)
    {
        $tp_department=$this->getTPDepartmentByName($student->unit->name);
        
        $values= $this-> initializeValues($staff->user,$action);
        $values['LoginAccount']=$staff->number;
        $values['EmpID']=$staff->number;
        $values['Name']=$staff->getName();
        $values['DeptCode']=$tp_department->Code;
        
        TPUserForSync::create($values);
    }
    // private function syncUserFromStudent(Student $student, $action)
    // {
    //     $tp_department=$this->getTPDepartmentByName($student->class->name);
        
    //     $values= $this-> initializeValues($student->user,$action);
    //     $values['LoginAccount']=$student->number;
    //     $values['EmpID']=$student->number;
    //     $values['Name']=$student->getName();
    //     $values['DeptCode']=$tp_department->Code;
        
    //     TPUserForSync::create($values);
    // }

    
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
             $values['Status']=3;
        }else if($action=='insert'){
            $values['Password']=$this->defaultPassword($user);
        }else if($action=='stop'){
            $values['Status']=2;
        }else if($action=='leave'){
            $values['Status']=2;
        }
        
        return $values;
    }

    private function defaultPassword($user)
    {
          return '0000';
    }


    

     

    
   
   
    
}