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
        $this->call(GradeSeeder::class);

        $this->call(UnitSeeder::class);	
        $this->call(ClassesSeeder::class);
        $this->call(UserSeeder::class);


        $this->call(TPSyncSeeder::class);
        $this->call(UpdateRecordSeeder::class);
    }
}
