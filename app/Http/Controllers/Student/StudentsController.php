<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Repositories\Students;
use App\Student;
use App\Http\Requests\StudentRequest;

class StudentsController extends BaseController
{
    protected $key='students';
    // public function __construct(Students $students) 
    // {
	// 	 $this->students=$students;
	// }
    public function indexOptions()
    {
        $departmentOptions=[];//$this->terms->options();
        return response()
            ->json([
                'departmentOptions' => $departmentOptions,
            ]);

    }
    public function index()
    {
        if(!request()->ajax()) return view('students.index');
        
        $request = request();

        $removed=(int)$request->removed; 
        $students=[];
        if($removed){
            $students=$this->students->trash()
                                           ->get();  
        }else{
            
            $students=$this->students->getAll()
                                       ->where('parent', 0)
                                       ->orderBy('active','desc')
                                       ->orderBy('order','desc')
                                       ->orderBy('updated_at','desc')
                                       ->get();  
        }
        
        
        return response()
            ->json([
                'students' => $students
            ]);
        
    }
    
    public function create()
    {
        if(!request()->ajax()){
            return view('students.create');                   
        }  

        $student= Student::initialize();

        return response()->json([
                    'student' => $student,
                ]); 
    }
    public function store(StudentRequest $request)
    {
        $current_user=$this->currentUser();
        $updated_by=$current_user->id;
        $removed=false;
        $values=$request->getValues($updated_by,$removed);
        
        $student= Student::create($values);
       
        return response()->json($student);
      
    }
    public function show($id)
    {
        if(!request()->ajax()){
            $menus=$this->menus($this->key);            
            return view('students.details')
                    ->with([ 'menus' => $menus,
                              'id' => $id     
                        ]);
        }

        $current_user=request()->user();
        
        $student=Student::findOrFail($id);
        if(!$student->canViewBy($current_user)){
            return  $this->unauthorized();   
        }

        $student->canEdit=$student->canEditBy($current_user);
        $student->canDelete=$student->canDeleteBy($current_user);
        return response()->json(['student' => $student]);
    }
    public function edit($id)
    {
        $student=$this->students->findOrFail($id);    
        $current_user=$this->currentUser();
        if(!$student->canEditBy($current_user)){
            return  $this->unauthorized(); 
        }

        return response()->json([
                    'student' => $student,
                ]);        
    }
    public function update(StudentRequest $request, $id)
    {
         $current_user=$this->currentUser();       
         $student = Student::findOrFail($id);
         if(!$student->canEditBy($current_user)){
            return  $this->unauthorized();       
         }
         $updated_by=$current_user->id;
         $removed=false;
         $values=$request->getValues($updated_by,$removed);  

         $student->update($values);
         return response()->json($student);
    }
    public function updateOrder(Request $request, $id)
    {
        $student=$this->students->findOrFail($id);
        $current_user=$this->currentUser();
        if(!$student->canEditBy($current_user)){
            return  $this->unauthorized();         
        }

        $updated_by=$current_user->id;
        $up=$request['up'];
        
        $student=$this->students->updateDisplayOrder($student ,$up, $updated_by);
        
        return response()
            ->json([
                'student' => $student
            ]);    

    }
    public function destroy($id)
    {
        $current_user=$this->currentUser();      
        $student=$this->students->findOrFail($id);
        if(!$student->canDeleteBy($current_user)){
            return  $this->unauthorized();     
        }
        $this->students->delete($id,$current_user->id);

        return response()
            ->json([
                'deleted' => true
            ]);
    }
    public function options()
    {
        $options=$this->students->options();

        return response()->json([
                     'options' => $options
                ]);   
    }
}
