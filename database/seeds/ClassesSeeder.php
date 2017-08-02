<?php

use Illuminate\Database\Seeder;

use App\Classes;
use App\Department;

class ClassesSeeder extends Seeder
{
  
    public function run()
    {
        $hb = Department::where('name','護理系')->first();
        $entity=Classes::create([
                'department_id' => $hb->id,
                'grade_id' => $hb->grades[0]->id,
                'name' => '護理一甲',
                'order' => 1,
            ]);
        $entity=Classes::create([
                'department_id' => $hb->id,
                'grade_id' => $hb->grades[0]->id,
                'name' => '護理一乙',
                'order' => 2,
            ]); 
        $entity=Classes::create([
                'department_id' => $hb->id,
                'grade_id' => $hb->grades[1]->id,
                'name' => '護理二甲',
                'order' => 1,
            ]);
        $entity=Classes::create([
                'department_id' => $hb->id,
                'grade_id' => $hb->grades[1]->id,
                'name' => '護理二乙',
                'order' => 2,
            ]);     
         $entity=Classes::create([
                'department_id' => $hb->id,
                'grade_id' => $hb->grades[2]->id,
                'name' => '護理三甲',
                'order' => 1,
            ]);
        $entity=Classes::create([
                'department_id' => $hb->id,
                'grade_id' => $hb->grades[2]->id,
                'name' => '護理三乙',
                'order' => 2,
            ]);    
         $entity=Classes::create([
                'department_id' => $hb->id,
                'grade_id' => $hb->grades[3]->id,
                'name' => '護理四甲',
                'order' => 1,
            ]);
        $entity=Classes::create([
                'department_id' => $hb->id,
                'grade_id' => $hb->grades[3]->id,
                'name' => '護理四乙',
                'order' => 2,
            ]);   
			
			
		$hm = Department::where('name','醫務管理系')->first();
        $entity=Classes::create([
                'department_id' => $hm->id,
                'grade_id' => $hm->grades[0]->id,
                'name' => '醫務一甲',
                'order' => 1,
            ]);
        $entity=Classes::create([
                'department_id' => $hm->id,
                'grade_id' => $hm->grades[0]->id,
                'name' => '醫務一乙',
                'order' => 2,
            ]); 
        $entity=Classes::create([
                'department_id' => $hm->id,
                'grade_id' => $hm->grades[1]->id,
                'name' => '醫務二甲',
                'order' => 1,
            ]);
        $entity=Classes::create([
                'department_id' => $hm->id,
                'grade_id' => $hm->grades[1]->id,
                'name' => '醫務二乙',
                'order' => 2,
            ]);     
         $entity=Classes::create([
                'department_id' => $hm->id,
                'grade_id' => $hm->grades[2]->id,
                'name' => '醫務三甲',
                'order' => 1,
            ]);
        $entity=Classes::create([
                'department_id' => $hm->id,
                'grade_id' => $hm->grades[2]->id,
                'name' => '醫務三乙',
                'order' => 2,
            ]);    
         $entity=Classes::create([
                'department_id' => $hm->id,
                'grade_id' => $hm->grades[3]->id,
                'name' => '醫務四甲',
                'order' => 1,
            ]);
        $entity=Classes::create([
                'department_id' => $hm->id,
                'grade_id' => $hm->grades[3]->id,
                'name' => '醫務四乙',
                'order' => 2,
            ]);          	
            
        $it = Department::where('name','資訊科技管理系')->first();
        $entity=Classes::create([
                'department_id' => $it->id,
                'grade_id' => $it->grades[0]->id,
                'name' => '資管一甲',
                'order' => 1,
            ]);
        $entity=Classes::create([
                'department_id' => $it->id,
                'grade_id' => $it->grades[0]->id,
                'name' => '資管一乙',
                'order' => 2,
            ]); 
        $entity=Classes::create([
                'department_id' => $it->id,
                'grade_id' => $it->grades[1]->id,
                'name' => '資管二甲',
                'order' => 1,
            ]);
        $entity=Classes::create([
                'department_id' => $it->id,
                'grade_id' => $it->grades[1]->id,
                'name' => '資管二乙',
                'order' => 2,
            ]);     
         $entity=Classes::create([
                'department_id' => $it->id,
                'grade_id' => $it->grades[2]->id,
                'name' => '資管三甲',
                'order' => 1,
            ]);
        $entity=Classes::create([
                'department_id' => $it->id,
                'grade_id' => $it->grades[2]->id,
                'name' => '資管三乙',
                'order' => 2,
            ]);    
         $entity=Classes::create([
                'department_id' => $it->id,
                'grade_id' => $it->grades[3]->id,
                'name' => '資管四甲',
                'order' => 1,
            ]);
        $entity=Classes::create([
                'department_id' => $it->id,
                'grade_id' => $it->grades[3]->id,
                'name' => '資管四乙',
                'order' => 2,
            ]);    

        $entity=Classes::create([
                'department_id' => $it->id,
                'grade_id' => $it->grades[4]->id,
                'name' => '資管碩一A',
                'order' => 1,
            ]); 
         $entity=Classes::create([
                'department_id' => $it->id,
                'grade_id' => $it->grades[5]->id,
                'name' => '資管碩二A',
                'order' => 1,
            ]);                                

          
       
    }
}