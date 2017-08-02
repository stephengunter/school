<?php

namespace App\Http\Controllers\Teamplus;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

use App\Repositories\Teamplus\Users;

class UsersController extends BaseController
{
   
    public function __construct(Users $users) 
    {
		$this->users=$users;
	}

    public function index()
    {
        
        $student->save();

        $this->users->syncUserFromStudent($student,'update');
        
        dd($student);
        
    }
    
    
}
