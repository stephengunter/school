<?php

namespace App\Http\Controllers\Teamplus;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

use App\Repositories\Staffs;
use App\Repositories\TPSync\Users as TPSyncUsers;

use App\TPSync\StaffUpdateRecord;

class StaffController extends BaseController
{
    protected $key='staffs';
    public function __construct(TPSyncUsers $TPSyncUsers,Staffs $staffs) 
    {
		 $this->staffs=$staffs;
         $this->TPSyncUsers=$TPSyncUsers;
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
            $exsit=$this->TPSyncUsers->userExist($number);
            
            if(!$exsit){
                $existStaffForSync=$this->TPSyncUsers->existUserForSync($number);
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
           
           StaffUpdateRecord::create([
               'name' => $staff->getName(),
               'number' => $staff->number,
               'department' => $staff->unit->name,
               'email' => $staff->user->email,
               'password' => '000000',
               'status' => 1,

           ]);
       

        }
        
       
         return response()->json([  'saved' => true ]);

    }
}
