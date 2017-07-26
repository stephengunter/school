<?php

use Illuminate\Database\Seeder;

use App\Unit;

class UnitSeeder extends Seeder
{
  
    public function run()
    {
        $hb = Unit::create([
                'parent' => 0,
                'code' => 'hb',
                'name'=> '教務處',
            ]);
        $cw = Unit::create([
                'parent' => $hb->id,
                'code' => 'cw',
                'name'=> '課務組',
            ]);    

        $cc = Unit::create([
                'parent' => 0,
                'code' => 'cc',
                'name'=> '電算中心',
            ]);

        $sd = Unit::create([
                'parent' => $cc->id,
                'code' => 'sd',
                'name'=> '軟體開發組',
            ]);
        $sm = Unit::create([
            'parent' => $cc->id,
            'code' => 'sm',
            'name'=> '系統管理組',
        ]);
    }
}
