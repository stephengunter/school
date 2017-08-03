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
                $unit=$this->units->findOrFail($unit_id);
                $children_ids=$this->units->getChildrenIds($unit_id);
                array_unshift($children_ids, $unit_id);

                $staffs=$staffs->whereIn('unit_id', $children_ids);
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
        
        $staff=Staff::with(['unit'])
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
        $staff=Staff::with(['unit'])
                        ->findOrFail($id);    
        $current_user=$this->currentUser();
        if(!$staff->canEditBy($current_user)){
            return  $this->unauthorized(); 
        }
        $staff->getName();

        $statusOptions=$this->staffs->statusOptions();
        $unitOptions=$this->units->options();

        return response()->json([
                    'staff' => $staff,
                    'unitOptions' => $unitOptions,
                    'statusOptions' => $statusOptions
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
