
<?php

use App\TPSync\SchoolEventCalendar;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;

class SchoolEventsSeeder extends Seeder 
{
	public function run()
	{
    
        $members='stephen,stephenchoe';
        SchoolEventCalendar::create([
            'code' => '122',
            'name' => '校務會議',
            'description' => '校務會議說明說明說明......',
            'start_time' => Carbon::create(2017, 8, 29, 8, 30, 0),
            'end_time' => Carbon::create(2017, 8, 29, 10, 00, 0),
            'members' => $members
        ]);

        $members='stephen,stephenchoe';
        SchoolEventCalendar::create([
            'code' => '128',
            'name' => '新生訓練',
            'description' => '新生訓練說明說明說明......',
            'start_time' => Carbon::create(2017, 9, 16, 9, 0, 0),
            'end_time' => Carbon::create(2017, 9, 16, 12, 0, 0),
            'members' => $members
        ]);
            
        
				
	}
}
	
