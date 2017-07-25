<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Repositories\Departments;
use App\Department;
use App\Http\Requests\DepartmentRequest;

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

        $removed=(int)$request->removed; 
        $departments=[];
        if($removed){
            $departments=$this->departments->trash()
                                           ->get();  
        }else{
            $departments=$this->departments->getAll()
                                       ->where('parent',0)
                                       ->orderBy('active','desc')
                                       ->orderBy('order','desc')
                                       ->orderBy('updated_at','desc')
                                       ->get();  
        }
        
        
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
    public function edit($id)
    {
        $department=$this->departments->findOrFail($id);    
        $current_user=$this->currentUser();
        if(!$department->canEditBy($current_user)){
            return  $this->unauthorized(); 
        }

        $department->getParent();

        $options=$this->departments->options();

        return response()->json([
                    'department' => $department,
                     'options' => $options
                ]);        
    }
    public function update(DepartmentRequest $request, $id)
    {
         $current_user=$this->currentUser();       
         $department = Department::findOrFail($id);
         if(!$department->canEditBy($current_user)){
            return  $this->unauthorized();       
         }
         $updated_by=$current_user->id;
         $removed=false;
         $values=$request->getValues($updated_by,$removed);  

         $department->update($values);
         return response()->json($department);
    }
    public function destroy($id)
    {
        $current_user=$this->currentUser();      
        $department=$this->departments->findOrFail($id);
        if(!$department->canDeleteBy($current_user)){
            return  $this->unauthorized();     
        }
        $this->departments->delete($id,$current_user->id);

        return response()
            ->json([
                'deleted' => true
            ]);
    }
}
