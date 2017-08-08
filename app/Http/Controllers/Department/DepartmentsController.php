<?php

namespace App\Http\Controllers\Department;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Repositories\Departments;
use App\Repositories\ClassesRepository;
use App\Department;
use App\Http\Requests\Department\DepartmentRequest;

use Excel;

class DepartmentsController extends BaseController
{
    protected $key='departments';
    public function __construct(Departments $departments,ClassesRepository $classesRepository) 
    {
		 $this->departments=$departments;
         $this->classesRepository=$classesRepository;
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
    private function tree()
    {
        $departments=$this->departments->getAll()
                                       ->where('parent', 0)
                                       ->orderBy('active','desc')
                                       ->orderBy('order','desc')
                                       ->orderBy('updated_at','desc')
                                       ->get(); 

        foreach ($departments as $department) {
            $children=$this->classesRepository->activeClasses($department->id);
            
            $department->children=$children;
           
        }
        
        return response()->json(['departments' => $departments ]);
            
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
        $department=Department::findOrFail($id);
        $parent_name='';
        $parent=Department::find($department->parent);
        if($parent) $parent_name=$parent->name;
        \App\DepartmentUpdateRecord::create([
            'department_id' => $department->id,
            'name' => $department->name,
            'parent' => $parent_name,
            'delete' => false,
            'date' => \Carbon\Carbon::today(),


        ]);
        dd('done');

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
         $values=$request->getValues($updated_by);  

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


    private function iniUnitFromExcel()
    {
          Excel::load('C:\Users\Stephen\Desktop\www\school\departments.xlsx', function($reader) {
            $units = $reader->all()->first();
            
            for($i = 0; $i < count($units); ++$i) {
                $unit=$units[$i];
                $code_1=(int)$unit['code_1'];
                $name_1=$unit['name_1'];

                $code_2=(int)$unit['code_2'];
                $name_2=$unit['name_2'];
            
                $parent_unit=null;
                if($code_2){
                    $parent_unit=\App\Unit::where('code', (string)$code_1)->where('name',$name_1)->first();
                    if(!$parent_unit){
                        $parent_unit=\App\Unit::create([
                            'code' => (string)$code_1,
                            'name'=> $name_1,
                        ]);
                    }

                    $exist=\App\Unit::where('code', (string)$code_2)->where('name',$name_2)->first();
                    if($exist){
                        $exist->update([
                            'code' => (string)$code_2,
                            'name'=> $name_2,
                            'parent' => $parent_unit->id
                        ]);
                    }else{
                        \App\Unit::create([
                            'code' => (string)$code_2,
                            'name'=> $name_2,
                            'parent' => $parent_unit->id
                        ]);
                    }

                    

                }else{
                    $exist=\App\Unit::where('code', (string)$code_1)->where('name',$name_1)->first();
                    if($exist){
                         $exist->update([
                            'code' => (string)$code_1,
                            'name'=> $name_1,
                        ]);
                    }else{
                        \App\Unit::create([
                            'code' => (string)$code_1,
                            'name'=> $name_1,
                        ]);
                    }
                }
            }    

            dd(count($units));
        });
    }

}
