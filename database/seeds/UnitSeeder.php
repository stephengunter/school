<?php

use Illuminate\Database\Seeder;

use App\Unit;
use Maatwebsite\Excel\Facades\Excel;

class UnitSeeder extends Seeder
{
  
    public function run()
    {
        Excel::load('C:\Users\Stephen\Desktop\php\departments.xlsx', function($reader) {
            $units = $reader->all()->first();
            
            for($i = 0; $i < count($units); ++$i) {
                $unit=$units[$i];
                $code_1=(int)$unit['code_1'];
                $name_1=$unit['name_1'];

                $code_2=(int)$unit['code_2'];
                $name_2=$unit['name_2'];
            
                $parent_unit=null;
                if($code_2){
                    $parent_unit=Unit::where('code', (string)$code_1)->where('name',$name_1)->first();
                    if(!$parent_unit){
                        $parent_unit=Unit::create([
                            'code' => (string)$code_1,
                            'name'=> $name_1,
                        ]);
                    }

                    $exist=Unit::where('code', (string)$code_2)->where('name',$name_2)->first();
                    if($exist){
                        $exist->update([
                            'code' => (string)$code_2,
                            'name'=> $name_2,
                            'parent' => $parent_unit->id
                        ]);
                    }else{
                        Unit::create([
                            'code' => (string)$code_2,
                            'name'=> $name_2,
                            'parent' => $parent_unit->id
                        ]);
                    }

                    

                }else{
                    $exist=Unit::where('code', (string)$code_1)->where('name',$name_1)->first();
                    if($exist){
                         $exist->update([
                            'code' => (string)$code_1,
                            'name'=> $name_1,
                        ]);
                    }else{
                        Unit::create([
                            'code' => (string)$code_1,
                            'name'=> $name_1,
                        ]);
                    }
                }
            }    

           
        });
    }
}
