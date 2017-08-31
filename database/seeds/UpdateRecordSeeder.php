
<?php

use App\User;
use App\Profile;
use App\Student;
use App\Staff;
use App\Department;
use App\Unit;

use App\TPSync\StudentUpdateRecord;
use App\TPSync\StaffUpdateRecord;
use App\TPSync\DepartmentUpdateRecord;


use Faker\Factory;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UpdateRecordSeeder extends Seeder 
{
	public function run()
	{
		$students=Student::all();
            for($i = 0; $i < 3; ++$i) {
                 $student=$students[$i];
                 StudentUpdateRecord::create([
                    'name'=>$student->getName(),
                    'number' =>$student->number,
                    'department' =>strtolower($student->class->code),
                    'email' => $student->user->email,
                    'password' => '000000',
                    'status' => 1
                 ]);
            }


            $staffs=Staff::all();
            for($i = 0; $i < 3; ++$i) {
                 $staff=$staffs[$i];
                 StaffUpdateRecord::create([
                    'name'=>$staff->getName(),
                    'number' =>$staff->number,
                    'department' =>strtolower($staff->unit->code),
                    'email' => $staff->user->email,
                    'password' => '000000',
                    'job_title' => '主任',
                    'extend' => '#2345',
                    'status' => 1
                 ]);
            }

            $units=Unit::all();
            for($i = 0; $i < 3; ++$i) {
                 $unit=$units[$i];
                 DepartmentUpdateRecord::create([
                    'department_id'=>$unit->code,
                    'name' =>$unit->name,
                    'parent' =>strtolower($unit->parentCode()),
                    'is_delete' => false,
                 ]);
            }

           
            



          
        
				
	}
}
	
