
<?php

use App\User;
use App\Profile;
use App\Student;
use App\Staff;
use App\Department;
use App\Unit;

use Faker\Factory;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder 
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		$departments=Department::all();
		$units=Unit::all();
        $faker = Factory::create();
		//  User::truncate();
        //  Profile::truncate();
		foreach(range(1, 50) as $i) {
        
            $user = User::create([
                'name' => $faker->name,
			
                'email' => $faker->unique()->safeEmail,
			
				'password' => 'secret',
				'remember_token' => str_random(10),
            ]);

			Profile::create([
                    'user_id' => $user->id,					
					'fullname'=> $faker->name,
                    'dob' => mt_rand(1950, 1995) . '-' .mt_rand(1, 12).'-'.mt_rand(1, 28),
                    'gender' => ( $i %2 == 0 ),
            ]);

			if($i %2 == 0 ){
				$department=$departments[mt_rand(0, count($departments)-1)];
				Student::create([
					'user_id' => $user->id,		
                    'department_id' => $department->id,					
					'number'=> (string)1061000 + $i,
                    'join_date' =>'2017-7-15',
               ]);
			}else{
				$unit=$units[mt_rand(0, count($units)-1)];
				Staff::create([
					'user_id' => $user->id,		
                    'unit_id' => $unit->id,					
					'number'=> (string)1061000 + $i,
                    'join_date' =>mt_rand(1995, 2016) . '-' .mt_rand(1, 12).'-'.mt_rand(1, 28),
               ]);
			}
            
        }  //end for


			$user = User::create([
					'name' => 'stephen',
					'email' =>'traders.com.tw@gmail.com',
					'phone' => '0936060049',
					'password' => 'secret',
					'email_confirmed' => true,
					'remember_token' => str_random(10),
                 ]);
			    Profile::create([
                    'user_id' => $user->id,					
					'fullname'=> '何金水',
                    'dob' =>'1979-3-12',
                    'gender' => 1,
                ]);

				
	}
}
	
