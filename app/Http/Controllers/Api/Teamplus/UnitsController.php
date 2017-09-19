<?php

namespace App\Http\Controllers\Api\Teamplus;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Route;
use App\Repositories\Units;
use App\Unit;

class UnitsController extends Controller
{
   
    public function __construct(Units $units) 
    {
		 $this->units=$units;
	}
   
    
    protected function index()
    {
        $units=$this->units->getTree();

        return response()->json($units);
    }
    
   
}
