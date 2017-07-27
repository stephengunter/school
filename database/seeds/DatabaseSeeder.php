<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CityDistrictSeeder::class);	
        $this->call(UnitSeeder::class);	

        $this->call(GradeSeeder::class);

	    $this->call(DepartmentSeeder::class);
        $this->call(UserSeeder::class);
    }
}
