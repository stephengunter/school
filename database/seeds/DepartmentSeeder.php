<?php

use Illuminate\Database\Seeder;

use App\Department;

class DepartmentSeeder extends Seeder
{
  
    public function run()
    {
        $grades=\App\Grade::orderBy('order')->get();
        $grades_count=count($grades);
        $hb = Department::create([
                'code' => 'hb',
                'name'=> '護理系',
            ]);
        for($i = 0; $i < 4; ++$i) {
            $hb->grades()->save($grades[$i]);
        }

        $hm = Department::create([
                'code' => 'hm',
                'name'=> '醫務管理系',
            ]);
        for($i = 0; $i < 4; ++$i) {
            $hm->grades()->save($grades[$i]);
        }

        $it = Department::create([
                'code' => 'it',
                'name'=> '資訊科技管理系',
            ]);   
        for($i = 0; $i < $grades_count; ++$i) {
            $it->grades()->save($grades[$i]);
        }       
       
    }
}
