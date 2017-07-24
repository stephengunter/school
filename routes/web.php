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
Route::resource('departments', 'DepartmentsController');
Route::resource('users', '\App\Http\Controllers\User\UsersController');


