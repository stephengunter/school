<?php

use Illuminate\Database\Seeder;

use App\Grade;

class GradeSeeder extends Seeder
{
  
    public function run()
    {
        Grade::create([
                'name'=> '大一',
                
            ]);
        Grade::create([
                'name'=> '大二',
            ]);  
        Grade::create([
                'name'=> '大三',
            ]);  
        Grade::create([
                'name'=> '大四',
            ]);  
        Grade::create([
            'name'=> '碩一',
        ]); 
        Grade::create([
            'name'=> '碩二',
        ]);            
       
    }
}
