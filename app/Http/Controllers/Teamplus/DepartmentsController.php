<?php

namespace App\Http\Controllers\Teamplus;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

use App\Repositories\Departments;
use App\Repositories\ClassesRepository;
use App\Repositories\TPSync\Departments as TPSyncDepartments;

use App\TPSync\DepartmentUpdateRecord;

class DepartmentsController extends BaseController
{
    protected $key='departments';
    public function __construct(TPSyncDepartments $TPSyncDepartments,Departments $departments,ClassesRepository $classesRepository) 
    {
		 $this->departments=$departments;
         $this->TPSyncDepartments=$TPSyncDepartments;
         $this->classesRepository=$classesRepository;
	}

    public function index()
    {
        $test=$this->TPSyncDepartments->syncDepartments();
        dd($test);

        if(!request()->ajax()) return view('tp-departments.index');

       
       
        $departments=$this->departments->getAll()->where('active',true)
                                       ->orderBy('parent')
                                       ->orderBy('order','desc')
                                       ->orderBy('updated_at','desc')
                                       ->get(); 
        
        $departmentList=[];
        foreach($departments as $department){
            
            $code=$department->code;
            $exsit=$this->TPSyncDepartments->getTPDepartmentByCode($code);
            if(!$exsit){
                $existUnitForSync=$this->TPSyncDepartments->existDepartmentForSync($code);
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
        $departmentList=\App\Department::whereIn('id',$ids)
                            ->orderBy('parent')
                            ->get();

        for($i = 0; $i < count($departmentList); ++$i){
           $department=$departmentList[$i];
           $department_id=$department->code;
           if(!$department_id){
               $department_id=$department->id;
           }
           DepartmentUpdateRecord::create([
               'department_id' => $department->code,
               'name' => $department->name,
               'parent' => $department->parentCode(),
               'is_delete' => false,

           ]);

        }
        
       
         return response()->json([  'saved' => true ]);

    }
}
