
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
		 $students=Student::all()->random(5);
         foreach ($students as $student) {
               UserUpdateRecord::create([
                    'user_id'=>$students->user->id,
                    'action' => 'Insert',
                    'date' => '2017-7-19',
               ]);
         }
          

		

				
	}
}
	
