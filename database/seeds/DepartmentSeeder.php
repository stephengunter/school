<?php

use Illuminate\Database\Seeder;

use App\Department;

class DepartmentSeeder extends Seeder
{
  
    public function run()
    {
        $hb = Department::create([
                'code' => 'hb',
                'name'=> '護理系',
            ]);
        $hm = Department::create([
                'code' => 'hm',
                'name'=> '醫務管理系',
            ]);  
        $it = Department::create([
                'code' => 'it',
                'name'=> '資訊科技管理系',
            ]);      
       
    }
}
