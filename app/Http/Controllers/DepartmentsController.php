<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Repositories\Departments;
use App\Department;

class DepartmentsController extends BaseController
{
    protected $key='departments';
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
    public function show($id)
    {
        if(!request()->ajax()){
            $menus=$this->menus($this->key);            
            return view('departments.details')
                    ->with([ 'menus' => $menus,
                              'id' => $id     
                        ]);
        }

        $current_user=request()->user();
        
        $department=Department::findOrFail($id);
        if(!$department->canViewBy($current_user)){
            return  $this->unauthorized();   
        }


        $department->getParent();

        $department->canEdit=$department->canEditBy($current_user);
        $department->canDelete=$department->canDeleteBy($current_user);
        return response()->json(['department' => $department]);
    }
}
