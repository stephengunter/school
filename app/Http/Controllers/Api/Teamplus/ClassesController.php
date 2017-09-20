<?php

namespace App\Http\Controllers\Api\Teamplus;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Route;
use App\Classes;

class ClassesController extends Controller
{
   
   
    
    protected function index()
    {
        $classList=Classes::where('removed',false)
                            ->orderBy('code')
                            ->get();

        return response()->json($classList);
    }
    
   
}
