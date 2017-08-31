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

Route::get('/login', function () {
    return view('auth.login');
});

Route::post('login', '\App\Http\Controllers\Auth\SessionsController@store');
Route::get('departments/options',['uses'=>'\App\Http\Controllers\Department\DepartmentsController@options']);
Route::put('departments/{id}/update-order',['uses'=>'\App\Http\Controllers\Department\DepartmentsController@updateOrder']);

Route::get('units/options',['uses'=>'\App\Http\Controllers\Department\UnitsController@options']);
Route::put('units/{id}/update-order',['uses'=>'\App\Http\Controllers\Department\UnitsController@updateOrder']);

Route::put('classes/{id}/update-order',['uses'=>'\App\Http\Controllers\Department\ClassesController@updateOrder']);
Route::get('classes/index-options',['uses'=>'\App\Http\Controllers\Department\ClassesController@indexOptions']);
Route::get('classes/options',['uses'=>'\App\Http\Controllers\Department\ClassesController@options']);


Route::put('grades/{id}/update-order',['uses'=>'\App\Http\Controllers\Department\GradesController@updateOrder']);


Route::get('students/index-options', '\App\Http\Controllers\Student\StudentsController@indexOptions');
Route::get('staffs/index-options', '\App\Http\Controllers\Staff\StaffsController@indexOptions');

// Route::resource('teamplus-users', '\App\Http\Controllers\Teamplus\UsersController');

Route::resource('departments', '\App\Http\Controllers\Department\DepartmentsController');
Route::resource('grades', '\App\Http\Controllers\Department\GradesController');
Route::resource('department-grades', '\App\Http\Controllers\Department\DepartmentGradesController', ['only' => ['index','edit','store']]);
Route::resource('units', '\App\Http\Controllers\Department\UnitsController');
Route::resource('classes', '\App\Http\Controllers\Department\ClassesController');
Route::resource('users', '\App\Http\Controllers\User\UsersController');
Route::resource('students', '\App\Http\Controllers\Student\StudentsController');
Route::resource('staffs', '\App\Http\Controllers\Staff\StaffsController');

Route::resource('contactinfoes', '\App\Http\Controllers\Contact\ContactInfoesController');
Route::resource('address', '\App\Http\Controllers\Contact\AddressController');
Route::resource('cities', '\App\Http\Controllers\Contact\CitiesController', ['only' => ['index']]);
Route::resource('districts', '\App\Http\Controllers\Contact\DistrictsController', ['only' => ['index']]);

Route::resource('tp-departments', '\App\Http\Controllers\Teamplus\DepartmentsController', ['only' => ['index','store']]);
Route::resource('tp-classes', '\App\Http\Controllers\Teamplus\ClassesController', ['only' => ['index','store']]);
Route::resource('tp-units', '\App\Http\Controllers\Teamplus\UnitsController', ['only' => ['index','store']]);
Route::resource('tp-students', '\App\Http\Controllers\Teamplus\StudentsController', ['only' => ['index','store']]);
Route::resource('tp-staff', '\App\Http\Controllers\Teamplus\StaffController', ['only' => ['index','store']]);
Route::resource('tp-groups', '\App\Http\Controllers\Teamplus\GroupsController', ['only' => ['index','store']]);
