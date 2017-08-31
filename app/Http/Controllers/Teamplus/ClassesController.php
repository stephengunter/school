<?php

namespace App\Http\Controllers\Teamplus;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

use App\Repositories\Departments;
use App\Repositories\ClassesRepository;

use App\Repositories\TPSync\Departments as TPSyncDepartments;
use App\TPSync\DepartmentUpdateRecord;

class ClassesController extends BaseController
{
    
    public function __construct(TPSyncDepartments $TPSyncDepartments,Departments $departments,ClassesRepository $classesRepository) 
    {
		 $this->departments=$departments;
         $this->TPSyncDepartments=$TPSyncDepartments;
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
            $code=$entity->code;
            $exsit=$this->TPSyncDepartments->getTPDepartmentByCode($code);
            if(!$exsit){
                $existDepartmentForSync=$this->TPSyncDepartments->existDepartmentForSync($code);
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
        $classList=\App\Classes::whereIn('id',$ids)
                            ->orderBy('department_id')
                            ->get();

        for($i = 0; $i < count($classList); ++$i){
           $entity=$classList[$i];
           $department_id=$entity->code;
           if(!$department_id){
               $department_id=$entity->id;
           }
           
           DepartmentUpdateRecord::create([
               'department_id' => $department_id,
               'name' => $entity->name,
               'parent' => $entity->department->code,
               'type' => 'class',
               'is_delete' => false,

           ]);

        }
        
       
            return response()->json([  'saved' => true ]);

    }
}
