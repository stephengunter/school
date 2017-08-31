<?php

use Illuminate\Database\Seeder;

use App\Classes;
use App\Department;
use Maatwebsite\Excel\Facades\Excel;

class ClassesSeeder extends Seeder
{
    public function run()
    {
         Excel::load('C:\Users\Stephen\Desktop\php\departments.xlsx', function($reader) {
            $classes = $reader->get()[1];
            for($i = 0; $i < count($classes); ++$i) {
                $entity=$classes[$i];
                $name=trim($entity['department']);
                $code=trim($entity['code']);
                $department=Department::where('name',$name)->first();
                if(!$department){
                    $department=Department::create([
                        'name'=>  $name,
                    ]);
                }
                $exist=Classes::where('code', $code)->where('name',$name)->first();
                        if($exist){
                            $exist->update([
                                'code' => $code,
                                'name'=>$name,
                                'department_id' => $department->id,
                                'grade_id' => 1
                            ]);
                        }else{
                            Classes::create([
                                'code' => $code,
                                'name'=>$name,
                                'department_id' => $department->id,
                                'grade_id' => 1
                            ]);
                        }
            }
        });
    }
  
    
}
