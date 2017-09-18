<?php

namespace App\Http\Controllers\Teamplus;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;


use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;

use Config;
use Carbon\Carbon;

use App\Console\Commands\SyncNotices;
use App\Services\Teamplus\GroupService;
use App\Repositories\Teamplus\Notices;
use App\TPSync\SchoolNotice;
use DB;

use App\Support\Helper;

class GroupsController extends BaseController
{
    public function __construct(GroupService  $groupService)
    {
        $this->groupService=$groupService;
    }

    function cscsc4ggtest()
    {
        
        $subs= \App\TPSync\GroupSync::find(173)->getMembers();
        return $subs;
    }

    function svcscsctest()
    {
        $repo=new \App\Repositories\Teamplus\Groups();

        $userNo=3504;
        $owner='';

       
         $sn_list= \App\Teamplus\TPPrivateChannel::where('UserNo',$userNo)
        ->where('IsDelete',false)->pluck('SN')->toArray();

       
        
        for($i=0; $i<count($sn_list); $i++){
         
            $repo->delete($sn_list[$i]);
          
        }
                                

                                 return 'done';

        $userNo=1025;
        $sn_list= \App\Teamplus\TPPrivateChannel::where('UserNo',$userNo)
                                ->pluck('SN')->toArray();

        
        $repo=new \App\Repositories\Teamplus\Groups();
        return $repo->delete(2073);
       return   \App\Teamplus\TPPrivateChannel::all();
    }

    function xplplxtest()
    {
        dd(\App\TPSync\SchoolEventCalendar::first());
        dd(\App\TPSync\SchoolEventCalendar::create([
            'code' => 'dd',
            'name' => 'dd',
            'members' => 'dd',
            'description' => 'dd',
            'start_time' => \Carbon\Carbon::now(),
            'end_time' => \Carbon\Carbon::now()

        ]));

        // $repo=new \App\Repositories\TPSync\Departments();
        // $repo->syncDepartments();
        // dd('done');
        
        // $this->groupService->syncGroups();
        // dd('done');

        // $from=2086;
        // $end=2168;
        // for( $i = $from ; $i <= $end ; $i++){
        //     $department=\App\Teamplus\TPDepartment::find($i);
        //     if($department){
        //         $userAccounts=\App\Teamplus\TPUser::where('DeptID', $i)
        //                                           ->pluck('LoginName')->toArray();
                
        //         $members=Helper::strFromArray($userAccounts);
        //         if($members){
        //             \App\TPSync\GroupSync::create([
        //                 'code' => $department->Code,
        //                 'name' => $department->Name,
        //                 'members' => $members,
        //                 'admin' => '',
    
        //             ]);
        //         }
        //     }
        // }

       
        
        return 'done';
        

        
        
    }

    function xsxsxtest()
    {
        // $this->groupService->syncGroups();
        // dd('done');
        $repo=new \App\Repositories\Teamplus\Notices();
        $members=['ss355','stephen','stephenchoe'];

        $type=1;
        $content='08333contentcontentcontentcontentcontent...';
        $file='';
        $file_name='';


       
        dd($repo->create($members,$type, $content, $file, $file_name));





        $team_id=2021;
        //  $result=$repo->removeMembers(['stephenchoe'],$team_id);
        //  dd($result);
        
        // $manager='stephen';
    // $result=$repo->addManager($team_id,$manager);
    //dd($result);
        // $members=['ss355','stephenchoe'];
        // $owner='ss355';
        // $manager='ss355';
        // $name='軟體開發組test';

        $result=$repo->details($team_id);
        $teamInfo=$result->TeamInfo;
        $members=$teamInfo->MemberList;
        $managers=$teamInfo->ManagerList;

        

        dd($teamInfo);

    }

    function xsxswwtest()
    {
        
        $this->syncNotices->handle();

    }

    function csvcsvstest()
    {
        $repo=new \App\Repositories\Teamplus\Notices();

        $notice=\App\TPSync\SchoolNotice::find(1);
        $attachment=$notice->attachments[0];

        $file_type=$attachment->file_type;
        $file_data=$attachment->file_data;
      
        $result=$repo->upload($file_type,$file_data);
        if($result->IsSuccess){
            dd('ok');
        }else dd('failed');

        return $repo->upload($file_type,$file_data);
        
    }
    
    function xxxsxsxtest()
    {
        $path= $_SERVER['DOCUMENT_ROOT'].'/images/uploads/test.png';
       // dd(file_exists($path));  
        $imagedata = file_get_contents($path);
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $file_data= base64_encode($imagedata);

       

        $notice= DB::transaction(function() 
        use($ext,$file_data){
              $notice=\App\TPSync\SchoolNotice::create([
                    'type_id'=>2,
                    'text_content' => 'test notice text_content with file',
                    'members' => 'ss355,stephen,stephenchoe',
              ]);
              
              $attachment=new \App\TPSync\NoticeAttachment([
                    'file_type'=> $ext,
                    'file_data' => $file_data,
                    'display_name' => '檔案顯示名稱'

              ]);
              $notice->attachments()->save($attachment);

              return $notice;
        });

        return $notice;
        

    }
    function xxxtest()
    {
       $members='ss355,stephen,stephenchoe';
        // 'type_id', 'text_content' ,'members',
        // 'media_content',
        \App\TPSync\SchoolNotice::create([
            'type_id'=>1,
            'text_content' => 'test notice text_content',
            'members' => $members,

        ]);

        dd('done');
        
    }
    
    public function xtest()
    {
        $repo=new \App\Repositories\Teamplus\Notices();
        $members=['ss355','stephen','stephenchoe'];

        $type=1;
        $content='08333contentcontentcontentcontentcontent...';
        $file='';
        $file_name='';


       
        return $repo->create($members,$type, $content, $file, $file_name);

    }

    public function index()
    {
        

        dd($this->test());
       // $this->api_sn=Config::get('teamplus.system.api_sn');

        // $calendar=\App\EventCalendar::first();
        
        // $account=$calendar->members[0]->member;
        // $name=$calendar->name;
        // $description=$calendar->description;
        // $start_time=new Carbon($calendar->start_time);
        // $end_time=new Carbon($calendar->end_time);

        

       
        //$result=$repo->create($account, $name, $description, $start_time, $end_time);
        dd($result);


          $end_time=Carbon::now();
          $members='ss355,stephenchoe,127790998';

         

          //$repo=new \App\Repositories\EventCalendars();
         

        //   dd($repo->delete($code));

         
        //   dd($repo->createOrUpdate($code,$name,$description,$start_time,$end_time,$members));



        // $members=['stephen', 'stephenchoe'];
        // $owner='ss355';
        // $manager='stephen';
        // $name='團隊AAA';
        // $body=$this->events->create($members, $owner, $manager ,$name);
        // $account='stephen';
        // $name='課務會議';
        // $description='descriptiondescription';
        // $start_time='2017-08-24 14:30:00';
        // $end_time='2017-08-24 16:00:00';
        // $body=$this->events->create($account, $name, $description, $start_time, $end_time);



        // dd($body->EventID);
        // return response()->json($body);
       
       
    }
    
    public function store(Request $request)
    {
       

    }
}
