<?php

namespace App\Http\Controllers\Department;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Repositories\Departments;
use App\Department;
use App\Http\Requests\Department\DepartmentRequest;

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

        $removed=(int)$request->removed; 
        $departments=[];
        if($removed){
            $departments=$this->departments->trash()
                                           ->get();  
        }else{
            
            $departments=$this->departments->getAll()
                                       ->where('parent', 0)
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
    
    public function create()
    {
        if(!request()->ajax()){
            return view('departments.create');                   
        }  

        $department= Department::initialize();

        return response()->json([
                    'department' => $department,
                ]); 
    }
    public function store(DepartmentRequest $request)
    {
        $current_user=$this->currentUser();
        $updated_by=$current_user->id;
        $removed=false;
        $values=$request->getValues($updated_by,$removed);
        
        $department= Department::create($values);
       
        return response()->json($department);
      
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

        return response()->json([
                    'department' => $department,
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
    public function updateOrder(Request $request, $id)
    {
        $department=$this->departments->findOrFail($id);
        $current_user=$this->currentUser();
        if(!$department->canEditBy($current_user)){
            return  $this->unauthorized();         
        }

        $updated_by=$current_user->id;
        $up=$request['up'];
        
        $department=$this->departments->updateDisplayOrder($department ,$up, $updated_by);
        
        return response()
            ->json([
                'department' => $department
            ]);    

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
    public function options()
    {
        $options=$this->departments->options();

        return response()->json([
                     'options' => $options
                ]);   
    }
}
