<?php

namespace App\Http\Controllers\Teamplus;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

use App\Repositories\Departments;
use App\Repositories\ClassesRepository;
use App\Repositories\Teamplus\Departments as TPDepartments;

class DepartmentsController extends BaseController
{
    protected $key='departments';
    public function __construct(TPDepartments $TPDepartments,Departments $departments,ClassesRepository $classesRepository) 
    {
		 $this->departments=$departments;
         $this->TPDepartments=$TPDepartments;
         $this->classesRepository=$classesRepository;
	}

    public function index()
    {
        
        if(!request()->ajax()) return view('tp-departments.index');

       
       
        $departments=$this->departments->getAll()->where('active',true)
                                       ->orderBy('parent')
                                       ->orderBy('order','desc')
                                       ->orderBy('updated_at','desc')
                                       ->get(); 
        
        $departmentList=[];
        foreach($departments as $department){
            $name=$department->name;
            $exsit=$this->TPDepartments->getTPDepartmentByName($name);
            
            if(!$exsit){
                $existDepartmentForSync=$this->TPDepartments->existDepartmentForSync($name);
                if(!$existDepartmentForSync)  array_push($departmentList, $department);
               
            }
        }                                
        
        return response()
            ->json([
                'departments' => $departmentList
            ]);
        
    }
    
    public function store(Request $request)
    {
        $ids=$request['department_ids'];
        for($i = 0; $i < count($ids); ++$i){
           $department=$this->departments->findOrFail($ids[$i]);
           
           \App\Teamplus\DepartmentUpdateRecord::create([
               'department_id' => $department->id,
               'name' => $department->name,
               'parent' => $department->parentName(),
               'delete' => false,

           ]);

        }
        
       
         return response()->json([  'saved' => true ]);

    }
}
