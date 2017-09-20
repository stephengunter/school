<?php

namespace App\Http\Controllers\Teamplus;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

use App\Repositories\Staffs;
use App\Repositories\TPSync\Users as TPSyncUsers;

use App\TPSync\SchoolNotice;

use DB;

class NoticesController extends BaseController
{
    public function create()
    {
        
        return view('tp-notice.create');
    }
    public function store(Request $request)
    {
        //dd($request->toArray());
        $has_file=isset($_FILES['Attachment']);

        $content = $_POST['Content'];

        $staff=false;
        if (isset($_POST['Staff'])) $staff=true;

        $teacher=false;
        if (isset($_POST['Teacher'])) $teacher=true;

        $student=false;
        if (isset($_POST['Student'])) $student=true;

        $levels=false;
        if (isset($_POST['Student'])) $student=true;

        
        $units=$_POST['Units'];
        $classes=$_POST['Classes'];
        $levels=$_POST['Levels'];
        $ps=$_POST['PS'];

        $reviewed=false;
        $createdBy='102000';  //使用者部門
        $updatedBy='51';  //使用者id

        $now=date('Y-m-d H:i:s');

        

        $values=[
            'Content' => $content,
            'Staff' => $staff,
            'Teacher' => $teacher,
            'Student' => $student,
            'Units' => $units,
            'Classes' => $classes,
            'Levels' => $levels,
            'PS' => $ps,
            'Reviewed' => false,
            'CreatedBy' => $createdBy,
            'CreatedAt' => $now,
            'UpdatedBy' => $updatedBy,
            'UpdatedAt' => $now,
        ];
        
        $notice_id = DB::table('Notices')->insertGetId($values);
        
        if(!$has_file) dd('done');
            
        $file_name = $_FILES['Attachment']['name'];
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        $file_title = $file_name;
        if (isset($_POST['Attachment_Title'])){
            $file_title =$_POST['Attachment_Title'];
        } 

        $file_data=base64_encode(file_get_contents($_FILES['Attachment']['tmp_name']));
        
        DB::table('NoticeAttachment')->insert(
            [  
                'Notice_Id' => $notice_id, 
                'Title' => $file_title,
                'Name'=> $file_name,
                'Type' => $file_ext,
                'FileData' => $file_data,
            ]
        );

        dd('done');
            
       

    }
    public function xxstore(Request $request)
    {
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
        
       
         return response()->json([  'saved' => true ]);

    }
}
