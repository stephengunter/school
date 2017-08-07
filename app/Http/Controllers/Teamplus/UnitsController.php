<?php

namespace App\Http\Controllers\Teamplus;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

use App\Repositories\Units;
use App\Repositories\Teamplus\Departments as TPDepartments;

class UnitsController extends BaseController
{
    
    public function __construct(TPDepartments $TPDepartments,Units $units) 
    {
		 $this->units=$units;
         $this->TPDepartments=$TPDepartments;
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
            $name=$unit->name;
            $exsit=$this->TPDepartments->getTPDepartmentByName($name);
            if(!$exsit){
                $existUnitForSync=$this->TPDepartments->existDepartmentForSync($name);
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
        for($i = 0; $i < count($ids); ++$i){
           $unit=$this->units->findOrFail($ids[$i]);
           \App\Teamplus\DepartmentUpdateRecord::create([
               'department_id' => $unit->id,
               'type' => 'unit',
               'name' => $unit->name,
               'parent' => $unit->parentName(),
               'delete' => false,

           ]);
        }
        
       
         return response()->json([  'saved' => true ]);

    }
}
