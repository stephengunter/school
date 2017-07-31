<?php

use Illuminate\Database\Seeder;

use App\Grade;

class GradeSeeder extends Seeder
{
  
    public function run()
    {
        Grade::create([
                'name'=> '大一',
                'order'=>1,
            ]);
        Grade::create([
                'name'=> '大二',
                'order'=>2,
            ]);  
        Grade::create([
                'name'=> '大三',
                'order'=>3,
            ]);  
        Grade::create([
                'name'=> '大四',
                'order'=>4,
            ]);  
        Grade::create([
            'name'=> '碩一',
             'order'=>5,
        ]); 
        Grade::create([
            'name'=> '碩二',
            'order'=>6,
        ]);            
       
    }
}
