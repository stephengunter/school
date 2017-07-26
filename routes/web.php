<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
     return view('app');
});
Route::get('/test', function () {
   return view('test');
});
Route::get('/login', function () {
    return view('auth.login');
});

Route::post('login', '\App\Http\Controllers\Auth\SessionsController@store');
Route::get('departments/options',['uses'=>'\App\Http\Controllers\DepartmentsController@options']);
Route::put('departments/{id}/update-order',['uses'=>'\App\Http\Controllers\DepartmentsController@updateOrder']);

Route::get('units/options',['uses'=>'\App\Http\Controllers\UnitsController@options']);
Route::put('units/{id}/update-order',['uses'=>'\App\Http\Controllers\UnitsController@updateOrder']);

Route::get('students/index-options', '\App\Http\Controllers\Student\StudentsController@indexOptions');


Route::resource('departments', 'DepartmentsController');
Route::resource('units', 'UnitsController');
Route::resource('users', '\App\Http\Controllers\User\UsersController');


