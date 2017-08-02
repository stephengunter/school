<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

use App\Repositories\Students;
use App\Repositories\Departments;
use App\Repositories\grades;
use App\Repositories\ClassesRepository;

use App\Student;
use App\Http\Requests\User\StudentRequest;

class StudentsController extends BaseController
{
    protected $key='students';
    public function __construct(Students $students,Departments $departments,
                                    Grades $grades, ClassesRepository $classesRepository) 
    {
		 $this->students=$students;
         $this->departments=$departments;
         $this->grades=$grades;
         $this->classesRepository=$classesRepository;
	}
    
    public function indexOptions()
    {
        $request = request();
        $departmentOptions=$this->departments->options();

        $gradeOptions=[];
        $classOptions=[];
        $department_id=(int)$request->department;
        $grade_id=(int)$request->grade; 

       
        if($department_id){
            $department=$this->departments->findOrFail($department_id);
            $gradeOptions=$this->grades->optionsConverting($department->grades);
            $classList=$this->classesRepository->activeClasses($department_id,$grade_id);
            $classOptions=$this->classesRepository
                                ->optionsConverting($classList);
        }else{
            $gradeOptions=$this->grades->options();
        }
        
        return response()
            ->json([
                'departmentOptions' => $departmentOptions,
                'gradeOptions' => $gradeOptions,
                'classOptions' => $classOptions,
            ]);

    }
    public function index()
    {
        if(!request()->ajax()) return view('students.index');
       
        $request = request();

        $removed=(int)$request->removed; 
       
        $students=[];
        if($removed){
            $students=$this->students->trash()->with(['department','class'])
                                     ->filterPaginateOrder();
                                             
        }else{
            $students=$this->students->getAll();
            $department_id=(int)$request->department; 
            if($department_id){
                $students=$students->where('department_id', $department_id);
            }
            $grade_id=(int)$request->grade; 
            if($grade_id){
                $activeClasses=$this->classesRepository->activeClasses($department_id, $grade_id)
                                                        ->pluck('id')->toArray();

                $students=$students->whereIn('class_id', $activeClasses);
            }

            $class_id=(int)$request->classes; 
            if($class_id){
                $students=$students->where('class_id', $class_id);
            }

            $students=$students->with(['department','class'])
                               ->orderBy('active','desc')->filterPaginateOrder();

                           
                                                
                                       
        }

        foreach ($students as $student) {
             $student->getName();
        }   
        
        return response() ->json(['model' => $students  ]);  
        
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

        $current_user=$this->currentUser();
        
        $student=Student::with(['department','class'])
                        ->findOrFail($id);
        if(!$student->canViewBy($current_user)){
            return  $this->unauthorized();   
        }
        $student->getName();
        $student->canEdit=$student->canEditBy($current_user);
        $student->canDelete=$student->canDeleteBy($current_user);
        return response()->json(['student' => $student]);
    }
    public function edit($id)
    {
        $student=Student::with(['department','class'])
                        ->findOrFail($id);    
        $current_user=$this->currentUser();
        if(!$student->canEditBy($current_user)){
            return  $this->unauthorized(); 
        }
        $student->getName();

        $departmentOptions=$this->departments->options();
        return response()->json([
                    'student' => $student,
                    'departmentOptions' => $departmentOptions,
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
         $values=$request->getValues($updated_by);  

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
