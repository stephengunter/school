
<?php

use App\TPSync\SchoolEventCalendar;
use App\TPSync\GroupSync;

use Faker\Factory;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TPSyncSeeder extends Seeder 
{
	public function run()
	{
        $members='ss355,stephenchoe,stephen';
        $event_code='event_1';
        $name='測試會議';
        $description=$name.'說明....';
        $start_time=Carbon::create(2017, 9, 5, 9, 30, 0);
        $end_time=Carbon::create(2017, 9, 5, 11, 0, 0);
        SchoolEventCalendar::create([
              'code'=>$event_code,
              'name' =>$name,
              'members' => $members,
              'description' =>$description,
              'start_time' => $start_time,
              'end_time' => $end_time,
           ]);

        $event_code='event_2';
        $name='新生安全講習';
        $description=$name.'說明....';
        $start_time=Carbon::create(2017, 9, 16, 10, 0, 0);
        $end_time=Carbon::create(2017, 9, 16, 12, 0, 0);
        SchoolEventCalendar::create([
              'code'=>$event_code,
              'name' =>$name,
              'members' => $members,
              'description' =>$description,
              'start_time' => $start_time,
              'end_time' => $end_time,
        ]);

		// $fillable = [  
        //     'code', 'name' ,'members', 'admin', 
        //     'is_delete', 'sync'
         
        // ];
        GroupSync::create([
            'code' => '100342',
            'name' => '軟體咖發組',
            'members' => 'ss355,stephen,stephenchoe',
            'admin' => 'stephen',
            'is_delete' => 0,
        ]);


        //$path= 'C:/Users/Stephen/Desktop/www/school/public/images/uploads/test.png';
        $path= 'C:/Users/Stephen/Desktop/www/school/public/images/uploads/testdoc.docx';
      
        $imagedata = file_get_contents($path);
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $file_data= base64_encode($imagedata);
 

        $notice=\App\TPSync\SchoolNotice::create([
            'type_id'=>2,
            'text_content' => 'test notice text_content with file',
            'members' => 'ss355,stephen,stephenchoe',
        ]);
      
        $attachment=new \App\TPSync\NoticeAttachment([
            'file_type'=> $ext,
            'file_data' => $file_data,
            'display_name' => '標準化帳號同步規格說明書'

        ]);
        $notice->attachments()->save($attachment);  
          
        
				
	}
}
	
