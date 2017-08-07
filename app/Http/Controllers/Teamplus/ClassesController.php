<?php

namespace App\Http\Controllers\Teamplus;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

use App\Repositories\Departments;
use App\Repositories\ClassesRepository;
use App\Repositories\Teamplus\Departments as TPDepartments;

class ClassesController extends BaseController
{
    
    public function __construct(TPDepartments $TPDepartments,Departments $departments,ClassesRepository $classesRepository) 
    {
		 $this->departments=$departments;
         $this->TPDepartments=$TPDepartments;
         $this->classesRepository=$classesRepository;
	}

    public function index()
    {
        if(!request()->ajax()) return view('tp-classes.index');
        $classesList=collect([]);
        $departments=$this->departments->getAll()->where('active',true)->get(); 
        foreach($departments as $department){
            $department_id=(int)$department->id; 
            $grade_id=0; 
            $classesList = $classesList->merge($this->classesRepository
                                                    ->activeClasses($department_id,$grade_id)
                                              );

        }
        
        
        $must_sync_classes=[];
        foreach($classesList as $entity){
            $name=$entity->name;
            $exsit=$this->TPDepartments->getTPDepartmentByName($name);
            if(!$exsit){
                $existDepartmentForSync=$this->TPDepartments->existDepartmentForSync($name);
                if(!$existDepartmentForSync) {
                   array_push($must_sync_classes, $entity);
                } 
               
            }
        }                                        
         
        return response() ->json([ 'classesList' => $must_sync_classes  ]);
           
               
          
        
    }
    
    public function store(Request $request)
    {
        $ids=$request['classes_ids'];
        for($i = 0; $i < count($ids); ++$i){
           $entity=$this->classesRepository->findOrFail($ids[$i]);
           
           \App\Teamplus\DepartmentUpdateRecord::create([
               'department_id' => $entity->id,
               'name' => $entity->name,
               'parent' => $entity->department->name,
               'type' => 'class',
               'delete' => false,

           ]);

        }
        
       
            return response()->json([  'saved' => true ]);

    }
}
