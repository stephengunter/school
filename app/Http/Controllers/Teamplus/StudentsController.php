<?php

namespace App\Http\Controllers\Teamplus;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

use App\Repositories\Students;
use App\Repositories\Teamplus\Users as TPUsers;

class StudentsController extends BaseController
{
    protected $key='students';
    public function __construct(TPUsers $TPUsers,Students $students) 
    {
		 $this->students=$students;
         $this->TPUsers=$TPUsers;
	}

    public function index()
    {
        
        if(!request()->ajax()) return view('tp-students.index');
       
       
        $students=$this->students->getAll()->where('active',true)
                                       ->orderBy('department_id')
                                       ->orderBy('class_id')
                                       ->orderBy('updated_at','desc')
                                       ->with(['user.profile','department','class'])
                                       ->take(8)->get(); 
        
        $studentList=[];
        foreach($students as $student){
            $number=$student->number;
            $exsit=$this->TPUsers->userExist($number);

           
            if(!$exsit){
                $existStudentForSync=$this->TPUsers->existUserForSync($number);
                if(!$existStudentForSync)  array_push($studentList, $student);
               
            }
        }                                
        
        return response()
            ->json([
                'students' => $studentList
            ]);
        
    }
    
    public function store(Request $request)
    {
        $ids=$request['student_ids'];
        for($i = 0; $i < count($ids); ++$i){
           $student=$this->students->findOrFail($ids[$i]);
           
           \App\Teamplus\StudentUpdateRecord::create([
               'name' => $student->getName(),
               'number' => $student->number,
               'department' => $student->class->name,
               'email' => $student->user->email,
               'password' => '000000',
               'status' => 1,

           ]);

        }
        
       
         return response()->json([  'saved' => true ]);

    }
}
