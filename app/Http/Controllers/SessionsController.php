<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;

class SessionsController extends Controller
{
    public function __construct() {
		$this->middleware('guest', ['except' => 'destroy']);
	}

	public function store(LoginRequest $request)
    {  
		$values=[
			'number' => $request['username'],
			'password' => $request['password'],
		];
		if (!auth()->attempt($values)) {
            return   response()->json(['msg' => '登入失敗' ]  ,  422);
		}

		return response()
                ->json([
                    'success' => true
                ]);
	}

	public function destroy() {
		auth()->logout();

		return response()
                ->json([
                    'success' => true
                ]);
	}
}
