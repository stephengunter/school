<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Repositories\Departments;

class DepartmentsController extends BaseController
{
    public function __construct(Departments $departments) 
    {
		 $this->departments=$departments;
	}

    public function index()
    {
        if(!request()->ajax()) return view('departments.index');
        $request = request();
        $mode=$request->mode; 
       
        if($mode=='tree'){
           return $this->tree();
        }

        dd('dsmn');
        $departments=$this->departments->getAll()
                                       ->where('active',true)
                                       ->where('parent',0)
                                       ->get();  
        if(count($departments)){
            foreach ($departments as $department) {
                $department->getChildren();
            }
        }
        // $departments=$this->departments->getById(2);
        // $departments->getChildren();
        return response()
            ->json([
                'departments' => $departments
            ]);
        
    }
    private function tree()
    {
        $departments=$this->departments->getAll()
                                       ->where('active',true)
                                       ->where('parent',0)
                                       ->get();  
        if(count($departments)){
            foreach ($departments as $department) {
                $department->getChildren();
            }
        }
        
        return response()->json(['departments' => $departments ]);
            
    }
}
