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
       
        
        $gradeOptions=$this->grades->options($selected_ids);
       
        
        return response()->json([
                    'selected_ids' => $selected_ids,
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
        
        $department->grades()->sync($grade_ids);
       
        return response()->json($department);
      
    }
    
}
