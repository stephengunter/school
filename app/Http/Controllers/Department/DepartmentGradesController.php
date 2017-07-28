<?php

namespace App\Http\Controllers\Department;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

use App\Repositories\Departments;
use App\Repositories\Grades;
use App\Department;

class DepartmentGradesController extends BaseController
{
    
    public function __construct(Departments $departments,Grades $grades) 
    {
		 $this->departments=$departments;
         $this->grades=$grades;
	}

    public function index()
    {
        $request = request();
        $department_id=$request->department; 
        
        $department=Department::findOrFail($department_id);
        $grades=$department->grades;
        
        
        return response()
            ->json([
                'grades' => $grades
            ]);
        
    }
     public function edit($id)
    {
        $department=Department::findOrFail($id);   
        $current_user=$this->currentUser();
        if(!$department->canEditBy($current_user)){
            return  $this->unauthorized(); 
        }
        $selected_ids = $department->grades->pluck('id')->toArray();

        // $all_grades=$this->grades->getAll()->get();
        // $gradeOptions=$this->grades->optionsConverting($all_grades);
        // for($i = 0; $i < count($gradeOptions); ++$i) {
        //     $gradeOptions[$i]['selected']=in_array($gradeOptions[$i]['value'], $selected_ids);
           
        // }

        $gradeOptions=$this->grades->options($selected_ids);
       
        
        return response()->json([
                    'department' => $department,
                    'gradeOptions' => $gradeOptions,
                ]);        
    }
    public function store(Request $request)
    {
        $department_id=$request['department'];
        $grade_ids=$request['grades'];

        $department=Department::findOrFail($department_id);
        $current_user=$this->currentUser();
        if(!$department->canEditBy($current_user)){
            return  $this->unauthorized();       
        }
        
        
        $department= Department::create($values);
       
        return response()->json($department);
      
    }
    
}
