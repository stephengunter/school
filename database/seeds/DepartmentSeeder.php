<?php

use Illuminate\Database\Seeder;

use App\Department;

class DepartmentSeeder extends Seeder
{
  
    public function run()
    {
        $hb = Department::create([
                'parent' => 0,
                'code' => 'hb',
                'name'=> '醫務管理系',
            ]);

        $cc = Department::create([
                'parent' => 0,
                'code' => 'cc',
                'name'=> '電算中心',
            ]);

        $sd = Department::create([
                'parent' => $cc->id,
                'code' => 'sd',
                'name'=> '軟體開發組',
            ]);
        $sm = Department::create([
            'parent' => $cc->id,
            'code' => 'sm',
            'name'=> '系統管理組',
        ]);
    }
}
