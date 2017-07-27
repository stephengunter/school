<?php

namespace App\Http\Controllers\Department;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Repositories\Departments;
use App\Department;

class DepartmentGradesController extends BaseController
{
    
    public function __construct(Departments $departments) 
    {
		 $this->departments=$departments;
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
