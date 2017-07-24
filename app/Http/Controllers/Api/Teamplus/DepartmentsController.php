<?php

namespace App\Http\Controllers\Api\Teamplus;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

use App\DepartmentForSync;
use Carbon\Carbon;

class DepartmentsController extends BaseController
{
    public function __construct() 
    {
		 
	}

    public function index()
    {
        return  response() ->json(['model' =>  DepartmentForSync::all() ]); 
    }

    public function store(Request $request)
    {
        $code=$request['Code']; 
        $name=$request['Name']; 
        $parentCode=$request['ParentCode']; 
        $description=$request['Description']; 

        $values=[
            'Code' => $code,
            'Name' => $name,
            'ParentCode' => $parentCode,
            'Description' => $description,
           
            'SyncStatus' => 0,
            'IsDelete' => 0,            
        ];

        $department=new DepartmentForSync($values);
        $department->UpdateTime=Carbon::now();
        
        dd($department->save());
    }
}
