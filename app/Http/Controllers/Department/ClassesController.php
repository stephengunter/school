<?php

namespace App\Http\Controllers\Department;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Department\ClassRequest;
use App\Classes;
use App\Repositories\ClassesRepository;
use App\Repositories\Departments;

class ClassesController extends BaseController
{
    
    public function __construct(ClassesRepository $classesRepository, Departments $departments) 
    {
		$this->classesRepository=$classesRepository;
        $this->departments=$departments;
	}

    public function index()
    {
        $current_user=$this->currentUser();

        $request = request();

        $removed=(int)$request->removed; 
        $classList=[];
        if($removed){
            $classList=$this->classesRepository->trash() ->get();  
                                          
        }else{
            $department_id=(int)$request->department; 
            $classList=$this->classesRepository->activeClasses($department_id)
                                                ->orderBy('order','desc')
                                                ->orderBy('updated_at','desc')
                                                ->get();  
        }

        foreach ($classList as $entity) {
             $entity->canEdit=$entity->canEditBy($current_user);
             $entity->canDelete=$entity->canDeleteBy($current_user);    
        }
        
        
        return response()
            ->json([
                'classList' => $classList
            ]);
        
    }
    
    public function create()
    {
        $request = request();
        $department_id=(int)$request->department;
        if(!$department_id) abort(404);
        $department=$this->departments->findOrFail($department_id);
       
        $entity= Classes::initialize($department);

        return response()->json([
                    'entity' => $entity
                ]); 
    }
    public function store(ClassRequest $request)
    {
        $current_user=$this->currentUser();
        $updated_by=$current_user->id;
        $removed=false;
        $values=$request->getValues($updated_by,$removed);
        
        $entity= Classes::create($values);
       
        return response()->json($entity);
      
    }
    public function show($id)
    {
        $current_user=request()->user();
        
        $entity=Classes::findOrFail($id);
        if(!$entity->canViewBy($current_user)){
            return  $this->unauthorized();   
        }

        $entity->canEdit=$entity->canEditBy($current_user);
        $entity->canDelete=$entity->canDeleteBy($current_user);
        return response()->json(['entity' => $entity]);
    }
    public function edit($id)
    {
        $entity=Classes::findOrFail($id);  
        $current_user=$this->currentUser();
        if(!$entity->canEditBy($current_user)){
            return  $this->unauthorized(); 
        }

        return response()->json([
                    'entity' => $entity,
                ]);        
    }
    public function update(ClassRequest $request, $id)
    {
         $current_user=$this->currentUser();       
         $entity = Classes::findOrFail($id);
         if(!$entity->canEditBy($current_user)){
            return  $this->unauthorized();       
         }
         $updated_by=$current_user->id;
         $values=$request->getValues($updated_by);  

         $entity->update($values);
         return response()->json($entity);
    }
    public function updateOrder(Request $request, $id)
    {
        $entity = Classes::findOrFail($id);
        $current_user=$this->currentUser();
        if(!$entity->canEditBy($current_user)){
            return  $this->unauthorized();         
        }

        $updated_by=$current_user->id;
        $up=$request['up'];
        
        $entity=$this->classesRepository->updateDisplayOrder($entity ,$up, $updated_by);
        
        return response()->json($entity);

    }
    public function destroy($id)
    {
        $current_user=$this->currentUser();      
        $entity = Classes::findOrFail($id);
        if(!$entity->canDeleteBy($current_user)){
            return  $this->unauthorized();     
        }
        $this->classesRepository->delete($id,$current_user->id);

        return response()
            ->json([
                'deleted' => true
            ]);
    }
    // public function options()
    // {
    //     $options=$this->classes->options();

    //     return response()->json([
    //                  'options' => $options
    //             ]);   
    // }
}
