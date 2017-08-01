
<?php

use App\User;
use App\Profile;
use App\Student;
use App\Staff;
use App\Department;
use App\Unit;
use App\UserUpdateRecord;

use Faker\Factory;
use Illuminate\Database\Seeder;

class UpdateRecordSeeder extends Seeder 
{
	public function run()
	{
		$students=Student::all();
            $role='Student';
            for($i = 0; $i < 3; ++$i) {
                 $student=$students[$i];
                 UserUpdateRecord::create([
                    'user_id'=>$student->user->id,
                    'role' => $role,
                    'action' => 'Insert',
                    'date' => '2017-7-19',
                 ]);
            }
            for($i = 3; $i < 6; ++$i) {
                 $student=$students[$i];
                 UserUpdateRecord::create([
                    'user_id'=>$student->user->id,
                    'role' => $role,
                    'action' => 'Update',
                    'date' => '2017-7-22',
                 ]);
            }
            for($i = 6; $i < 9; ++$i) {
                 $student=$students[$i];
                 UserUpdateRecord::create([
                    'user_id'=>$student->user->id,
                    'role' => $role,
                    'action' => 'Delete',
                    'date' => '2017-7-24',
                 ]);
            }

            $staffs=Staff::all();
            $role='Staff';
            $staff=$staffs[0];
            UserUpdateRecord::create([
                  'user_id'=>$staff->user->id,
                  'role' => $role,
                  'action' => 'Insert',
                  'date' => '2017-7-19',
            ]);
            $staff=$staffs[1];
            UserUpdateRecord::create([
                  'user_id'=>$staff->user->id,
                  'role' => $role,
                  'action' => 'Update',
                  'date' => '2017-7-19',
            ]);
         
            $staff=$staffs[2];
            UserUpdateRecord::create([
                  'user_id'=>$staff->user->id,
                  'role' => $role,
                  'action' => 'Delete',
                  'date' => '2017-7-24',
            ]);
        
				
	}
}
	
