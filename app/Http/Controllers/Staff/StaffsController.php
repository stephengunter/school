<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

use App\Repositories\Staffs;
use App\Repositories\Units;

use App\Staff;
use App\Http\Requests\User\StaffRequest;

class StaffsController extends BaseController
{
    protected $key='staffs';
    public function __construct(Staffs $staffs, Units $units) 
    {
		 $this->staffs=$staffs;
         $this->units=$units;
	}
    
    public function indexOptions()
    {
        $request = request();
        $unitOptions=$this->units->options();
        
        return response()
            ->json([
                'unitOptions' => $unitOptions
            ]);

    }
    public function index()
    {
        if(!request()->ajax()) return view('staffs.index');
       
        $request = request();

        $removed=(int)$request->removed; 
       
        $staffs=[];
        if($removed){
            $staffs=$this->staffs->trash()->with(['unit'])
                                     ->filterPaginateOrder();
                                             
        }else{
            $staffs=$this->staffs->getAll();
            $unit_id=(int)$request->unit; 
            if($unit_id){
                $staffs=$staffs->where('unit_id', $unit_id);
            }
            

            $staffs=$staffs->with(['unit'])
                               ->orderBy('status','desc')->filterPaginateOrder();

                           
                                                
                                       
        }

        foreach ($staffs as $staff) {
             $staff->getName();
        }   
        
        return response() ->json(['model' => $staffs  ]);  
        
    }
    
    public function create()
    {
        if(!request()->ajax()){
            return view('staffs.create');                   
        }  

        $staff= Staff::initialize();

        return response()->json([
                    'staff' => $staff,
                ]); 
    }
    public function store(StaffRequest $request)
    {
        $current_user=$this->currentUser();
        $updated_by=$current_user->id;
        $removed=false;
        $values=$request->getValues($updated_by,$removed);
        
        $staff= Staff::create($values);
       
        return response()->json($staff);
      
    }
    public function show($id)
    {
        if(!request()->ajax()){
            $menus=$this->menus($this->key);            
            return view('staffs.details')
                    ->with([ 'menus' => $menus,
                              'id' => $id     
                        ]);
        }

        $current_user=$this->currentUser();
        
        $staff=Staff::with(['department','class'])
                        ->findOrFail($id);
        if(!$staff->canViewBy($current_user)){
            return  $this->unauthorized();   
        }
        $staff->getName();
        $staff->canEdit=$staff->canEditBy($current_user);
        $staff->canDelete=$staff->canDeleteBy($current_user);
        return response()->json(['staff' => $staff]);
    }
    public function edit($id)
    {
        $staff=Staff::with(['department','class'])
                        ->findOrFail($id);    
        $current_user=$this->currentUser();
        if(!$staff->canEditBy($current_user)){
            return  $this->unauthorized(); 
        }
        $staff->getName();

        $departmentOptions=$this->departments->options();
        $department_id=(int)$staff->department_id; 
        $grade_id=0; 
        $classesOptions=$this->classesRepository->options($department_id,$grade_id);
        return response()->json([
                    'staff' => $staff,
                    'departmentOptions' => $departmentOptions,
                    'classesOptions' => $classesOptions,
                ]);        
    }
    public function update(StaffRequest $request, $id)
    {
         $current_user=$this->currentUser();       
         $staff = Staff::findOrFail($id);
         if(!$staff->canEditBy($current_user)){
            return  $this->unauthorized();       
         }
         $updated_by=$current_user->id;
         $values=$request->getValues($updated_by);  
         
         $staff->update($values);

         $sync=new \App\Repositories\Teamplus\Users();
         $sync->syncUserFromStaff($staff, 'update');


         return response()->json($staff);
    }
    public function updateOrder(Request $request, $id)
    {
        $staff=$this->staffs->findOrFail($id);
        $current_user=$this->currentUser();
        if(!$staff->canEditBy($current_user)){
            return  $this->unauthorized();         
        }

        $updated_by=$current_user->id;
        $up=$request['up'];
        
        $staff=$this->staffs->updateDisplayOrder($staff ,$up, $updated_by);
        
        return response()
            ->json([
                'staff' => $staff
            ]);    

    }
    public function destroy($id)
    {
        $current_user=$this->currentUser();      
        $staff=$this->staffs->findOrFail($id);
        if(!$staff->canDeleteBy($current_user)){
            return  $this->unauthorized();     
        }
        $this->staffs->delete($id,$current_user->id);

        return response()
            ->json([
                'deleted' => true
            ]);
    }
    public function options()
    {
        $options=$this->staffs->options();

        return response()->json([
                     'options' => $options
                ]);   
    }
}
