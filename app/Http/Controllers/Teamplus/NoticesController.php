<?php

namespace App\Http\Controllers\Teamplus;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;

use App\Repositories\Staffs;
use App\Repositories\TPSync\Users as TPSyncUsers;

use App\TPSync\SchoolNotice;

class NoticesController extends BaseController
{
    public function create()
    {

        return view('tp-notice.create');
    }
    public function store(Request $request)
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
