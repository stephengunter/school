<?php

namespace App\Http\Controllers\Teamplus;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

use App\Teamplus\TPUser;

class UsersController extends BaseController
{
   
    public function __construct() 
    {
		
	}

    public function index()
    {
        $users=TPUser::where('UserName','鍾吉偉')->get();
        
        return response()
            ->json([
                'users' => $users
            ]);
        
    }
    
    
}
