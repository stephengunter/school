
<?php

use App\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder 
{
	public function run()
	{
         $faker = Factory::create();
		
		 foreach(range(1, 30) as $i) {
            User::create([
                'SID' => $faker->ean8,
                'name' => $faker->name,
                'fullname'=> $faker->name,
                'email' => $faker->unique()->safeEmail,
                'phone' => '09' . $faker->ean8, 
                'dob' => mt_rand(1950, 1995) . '-' .mt_rand(1, 12).'-'.mt_rand(1, 28),
                'gender' => ( $i %2 == 0 ),
				'password' => 'secret',
				'remember_token' => str_random(10),
            ]);
	    }

	    User::create([
                'SID' => 'F124597024',
                'name' => '阿水',
                'fullname'=> '鍾吉偉',
                'email' => 'traders.com.tw@gmail.com',
                'phone' => '0936060049' , 
                'dob' => '1979-3-12',
                'gender' => 1,
				'password' => 'secret',
                'number' => 'ss355',
				'remember_token' => str_random(10),
            ]);

    }
}
	
