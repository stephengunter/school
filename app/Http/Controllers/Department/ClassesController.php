<?php

namespace App\Http\Controllers\Department;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Department\ClassRequest;
use App\Classes;
use App\Repositories\ClassesRepository;

class ClassesController extends BaseController
{
    
    public function __construct(ClassesRepository $classesRepository) 
    {
		 $this->classesRepository=$classesRepository;
	}

    public function index()
    {
        $request = request();

        $removed=(int)$request->removed; 
        $classList=[];
        if($removed){
            $classList=$this->classesRepository->trash() ->get();  
                                          
        }else{
            
            $classList=$this->classesRepository->getAll()
                                       ->where('parent', 0)
                                       ->orderBy('active','desc')
                                       ->orderBy('order','desc')
                                       ->orderBy('updated_at','desc')
                                       ->get();  
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

        $entity= Classes::initialize();

        return response()->json([
                    'entity' => $entity,
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
         $removed=false;
         $values=$request->getValues($updated_by,$removed);  

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
