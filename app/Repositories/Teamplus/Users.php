<?php

namespace App\Repositories\Teamplus;

use DB;
use App\User;
use App\Student;
use App\Staff;

use App\Teamplus\StudentUpdateRecord;
use App\Teamplus\StaffUpdateRecord;
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
       
        // $this->syncStaffs();
        $this->syncStudents();  
    }
    public function syncStudents()
    {
        $records=StudentUpdateRecord::where('done', false )->get();
       
        foreach($records as $record){
               $number=$record->number;
               $email=$record->email;
               $name=$record->name;
               $class=$record->department;
               $status=$record->status;
               
               $done=$this->syncUserFromStudent($number, $email,$name, $class,$status);
               if($done){
                   $record->done=true;
                   $record->save();
               }
               
        }
    }
    public function syncStaffs()
    {
        $records=StaffUpdateRecord::where('done', false )->get();
        foreach($records as $record){
               $number=$record->number;
               $email=$record->email;
               $name=$record->name;
               $department=$record->department;
               $job_title=$record->job_title;
               $extend=$record->extend;
               $status=$record->status;
               $this->syncUserFromStaff($number, $email, $name, $department, $job_title, $extend  ,$status);

               $record->done=true;
               $record->save();
        }
    }
    public function xxsyncUsers()
    {
         $records=UserUpdateRecord::where('done', false )->get();
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

    public function syncUserFromStudent($number, $email, $name, $class,$status)
    {
        $tp_department=$this->getTPDepartmentByName($class);

        if($tp_department){
            $values=TPUserForSync::initialize();
            $values['LoginAccount']=$number;
            $values['Email']=$email;
            $values['EmpID']=$number;
            $values['Name']=$name;
            $values['DeptCode']=$tp_department->Code;
            $values['Status']=$status;
            
            return $this->saveUserForSync($values);
        
        }else{
             return null;
        }

        
    }
    public function syncUserFromStaff($number, $email, $name, $department, $job_title, $extend  ,$status)
    {
        $tp_department=$this->getTPDepartmentByName($department);

        $values=TPUserForSync::initialize();
        $values['LoginAccount']=$number;
        $values['Email']=$email;
        $values['EmpID']=$number;
        $values['Name']=$name;
        $values['DeptCode']=$tp_department->Code;
        $values['JobTitle']=$job_title;
        $values['Extend']=$extend;
        $values['Status']=$status;
        
        $this->saveUserForSync($values);
        
    }
    private function saveUserForSync($values)
    {
        $exist_record=$this->existUserForSync($values['LoginAccount']);
        if($exist_record){
           return $exist_record->update($values);
        }else{
           return TPUserForSync::create($values);
        }
    }
    private function xxsyncUserFromStudent(Student $student, $action)
    {
        $tp_department=$this->getTPDepartmentByName($student->class->name);
        
        $values= $this-> initializeValues($student->user,$action);
        $values['LoginAccount']=$student->number;
        $values['EmpID']=$student->number;
        $values['Name']=$student->getName();
        $values['DeptCode']=$tp_department->Code;
        
        
        $exist_record=$this->existUserForSync($values['LoginAccount']);
        if($exist_record){
            $exist_record->update($values);
        }else{
            TPUserForSync::create($values);
        }
    }
    private function xxsyncUserFromStaff(Staff $staff, $action)
    {
        $tp_department=$this->getTPDepartmentByName($staff->unit->name);
        
        $values= $this-> initializeValues($staff->user,$action);
        $values['LoginAccount']=$staff->number;
        $values['EmpID']=$staff->number;
        $values['Name']=$staff->getName();
        $values['DeptCode']=$tp_department->Code;

        $exist_record=$this->existUserForSync($values['LoginAccount']);
        if($exist_record){
            $exist_record->update($values);
        }else{
            TPUserForSync::create($values);
        }
        
    }
    
    private function getTPDepartmentByName($name)
    {
         return TPDepartment::where('Name',$name)->first();
    }
    private function xxinitializeValues(User $user,$action)
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

    private function xxdefaultPassword($user)
    {
          return '0000';
    }
    public function userExist($account)
    {
          return TPUser::where('LoginName',$account)->first();
    }
    public function existUserForSync($account)
    {
          return TPUserForSync::where('SyncStatus',0)
                             ->where('LoginAccount',$account)->first();
    }


    

     

    
   
   
    
}