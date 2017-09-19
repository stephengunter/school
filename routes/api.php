<?php

use Illuminate\Http\Request;


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::resource('/units', '\App\Http\Controllers\Api\Teamplus\UnitsController',
['only' => ['index']]);