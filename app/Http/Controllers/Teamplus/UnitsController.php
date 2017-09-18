<?php

namespace App\Http\Controllers\Teamplus;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

use App\Repositories\Units;
use App\Repositories\TPSync\Departments as TPSyncDepartments;

use App\TPSync\DepartmentUpdateRecord;

class UnitsController extends BaseController
{
    
    public function __construct(TPSyncDepartments $TPSyncDepartments,Units $units) 
    {
		 $this->units=$units;
         $this->TPSyncDepartments=$TPSyncDepartments;
    }
   

    public function index()
    {
       
        if(!request()->ajax()) return view('tp-units.index');

        
        $units=$this->units->getAll()->where('active',true)
                                       ->orderBy('parent')
                                       ->orderBy('order','desc')
                                       ->orderBy('updated_at','desc')
                                       ->get(); 
        
        $unitList=[];
        foreach($units as $unit){
            $code=$unit->code;
            $exsit=$this->TPSyncDepartments->getTPDepartmentByCode($code);
            if(!$exsit){
                $existUnitForSync=$this->TPSyncDepartments->existDepartmentForSync($code);
                if(!$existUnitForSync)  array_push($unitList, $unit);
               
            }
        }                                        
         
        return response()
            ->json([
                'units' => $unitList
            ]);
        
    }
    
    public function store(Request $request)
    {
        $ids=$request['unit_ids'];
        $unitList=\App\Unit::whereIn('id',$ids)
                            ->orderBy('parent')
                            ->get();
        for($i = 0; $i < count($unitList); ++$i){
           $unit=$unitList[$i];
           $department_id=$unit->code;
           if(!$department_id){
               $department_id=$unit->id;
           }
           DepartmentUpdateRecord::create([
               'department_id' => $department_id,
               'type' => 'unit',
               'name' => $unit->name,
               'parent' => $unit->parentCode(),
               'is_delete' => false,

           ]);
        }
        
       
         return response()->json([  'saved' => true ]);

    }
}
