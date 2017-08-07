<?php

namespace App\Http\Controllers\Teamplus;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

use App\Repositories\Staffs;
use App\Repositories\Teamplus\Users as TPUsers;

class StaffController extends BaseController
{
    protected $key='staffs';
    public function __construct(TPUsers $TPUsers,Staffs $staffs) 
    {
		 $this->staffs=$staffs;
         $this->TPUsers=$TPUsers;
	}

    public function index()
    {
        
        if(!request()->ajax()) return view('tp-staff.index');
       
       
        $staffs=$this->staffs->getAll()->where('status','>' , 0)
                                       ->orderBy('unit_id')
                                       ->orderBy('number')
                                       ->orderBy('updated_at','desc')
                                       ->with(['user.profile','unit'])
                                       ->take(8)->get(); 
        
        $staffList=[];
        foreach($staffs as $staff){
            $number=$staff->number;
            $exsit=$this->TPUsers->userExist($number);
            
            if(!$exsit){
                $existStaffForSync=$this->TPUsers->existUserForSync($number);
                if(!$existStaffForSync)  array_push($staffList, $staff);
               
            }
        }                                
        
        return response()
            ->json([
                'staffs' => $staffList
            ]);
        
    }
    
    public function store(Request $request)
    {
        $ids=$request['staff_ids'];
        for($i = 0; $i < count($ids); ++$i){
           $staff=$this->staffs->findOrFail($ids[$i]);
           
           \App\Teamplus\StaffUpdateRecord::create([
               'name' => $staff->getName(),
               'number' => $staff->number,
               'department' => $staff->class->name,
               'email' => $staff->user->email,
               'password' => '000000',
               'status' => 1,

           ]);

        }
        
       
         return response()->json([  'saved' => true ]);

    }
}
