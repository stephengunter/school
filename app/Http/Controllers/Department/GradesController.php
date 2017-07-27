<?php

namespace App\Http\Controllers\Department;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Department\GradeRequest;
use App\Grade;
use App\Repositories\Grades;

class GradesController extends BaseController
{
    
    public function __construct(Grades $grades) 
    {
		
        $this->grades=$grades;
	}

    public function index()
    {
        if(!request()->ajax()) return view('grades.index');

        $current_user=$this->currentUser();

        $request = request();

        $removed=(int)$request->removed; 
        $gradeList=[];
        if($removed){
            $gradeList=$this->grades->trash() ->get();  
                                          
        }else{
            $gradeList=$this->grades->getAll()
                                    ->orderBy('order','desc')
                                    ->orderBy('updated_at','desc')
                                    ->get();  
        }

        foreach ($gradeList as $grade) {
             $grade->canEdit=$grade->canEditBy($current_user);
             $grade->canDelete=$grade->canDeleteBy($current_user);    
        }
        
        
        return response()
            ->json([
                'gradeList' => $gradeList
            ]);
        
    }
    
    public function create()
    {
        $grade= Grade::initialize();

        return response()->json([
                    'grade' => $grade
                ]); 
    }
    public function store(GradeRequest $request)
    {
        $current_user=$this->currentUser();
        $updated_by=$current_user->id;
        $values=$request->getValues($updated_by);
        
        $grade= Grade::create($values);
       
        return response()->json($grade);
      
    }
    public function show($id)
    {
        $current_user=request()->user();
        
        $grade=Grades::findOrFail($id);
        if(!$grade->canViewBy($current_user)){
            return  $this->unauthorized();   
        }

        $grade->canEdit=$grade->canEditBy($current_user);
        $grade->canDelete=$grade->canDeleteBy($current_user);
        return response()->json(['grade' => $grade]);
    }
    public function edit($id)
    {
        $grade=Grade::findOrFail($id);  
        $current_user=$this->currentUser();
        if(!$grade->canEditBy($current_user)){
            return  $this->unauthorized(); 
        }

        return response()->json([
                    'grade' => $grade,
                ]);        
    }
    public function update(GradeRequest $request, $id)
    {
         $current_user=$this->currentUser();       
         $grade = Grade::findOrFail($id);
         if(!$grade->canEditBy($current_user)){
            return  $this->unauthorized();       
         }
         $updated_by=$current_user->id;
         $values=$request->getValues($updated_by);  

         $grade->update($values);
         return response()->json($grade);
    }
    public function updateOrder(Request $request, $id)
    {
        $grade = Grade::findOrFail($id);
        $current_user=$this->currentUser();
        if(!$grade->canEditBy($current_user)){
            return  $this->unauthorized();         
        }

        $updated_by=$current_user->id;
        $up=$request['up'];
        
        $grade=$this->grades->updateDisplayOrder($grade ,$up, $updated_by);
        
        return response()->json($grade);

    }
    public function destroy($id)
    {
        $current_user=$this->currentUser();      
        $grade = Grade::findOrFail($id);
        if(!$grade->canDeleteBy($current_user)){
            return  $this->unauthorized();     
        }
        $this->grades->delete($id,$current_user->id);

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
