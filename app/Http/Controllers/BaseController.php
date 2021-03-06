<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Route;
use App\Http\Middleware\CheckAdmin;

class BaseController extends Controller
{
    protected $checkAdmin;
    public function __construct()
    {
          
          
	}
    protected function setMiddleware(array $exceptAdmin, array $allowVisitors,$key='admin')
    {
       
        $this->middleware($key, ['except' => array_merge($exceptAdmin,$allowVisitors) ]);

        if(count($exceptAdmin)) $this->middleware($key, ['only' => $exceptAdmin]);
        
    }
    protected function setCheckAdmin($checkAdmin)
    {
        $this->checkAdmin=$checkAdmin;
    }
   
    protected function currentUser()
    {
        return \App\User::find(51);
        if($this->checkAdmin){
            return $this->checkAdmin->currentUser();
        }else{
           return request()->user();
        }
        
    }
    protected function unauthorized()
    {
        return  response()->json(['msg' => '權限不足' ]  ,  401);  
    }
    protected function menus($key)
    {
        $current=Route::current()->uri();
       
        if($key=='signups'){
           return array(
                [
                    'id' => 1,
                    'text' => '報名與繳費',
                    'path' => '/signups',
                    'active' => $current !='signups/new-user'
                ],
                [
                    'id' => 2,
                    'text' => '新學員報名',
                    'path' => '/signups/new-user',
                    'active' => $current=='signups/new-user'
                ],
            );
        } 
        if($key=='refunds'){
           return array(
                [
                    'id' => 1,
                    'text' => '退費管理',
                    'path' => '/refunds',
                    'active' => $current !='refunds/create'
                ],
                [
                    'id' => 2,
                    'text' => '新增退費申請',
                    'path' => '/refunds/create',
                    'active' => $current=='refunds/create'
                ],
            );
        } 
        if($key=='users' || $key=='volunteers' ){
           return array(
                [
                    'id' => 1,
                    'text' => '使用者管理',
                    'path' => '/users',
                    'active' => $current=='users'
                ],
                [
                    'id' => 2,
                    'text' => '新增使用者',
                    'path' => '/users/create',
                    'active' => $current=='users/create'
                ],
               
            );
        }
        if($key=='teachers'){
           return array(
                [
                    'id' => 1,
                    'text' => '教師管理',
                    'path' => '/teachers',
                    'active' => $current!='teachers/create'
                ],
                [
                    'id' => 2,
                    'text' => '新增教師',
                    'path' => '/teachers/create',
                    'active' => $current=='teachers/create'
                ],
               
            );
        }
        if($key =='courses' || $key =='lessons' || $key =='categories'
            || $key =='admissions'|| $key =='registers'){
           return array(
                [
                    'id' => 1,
                    'text' => '課程管理',
                    'path' => '/courses',
                    'active' => $current=='courses'
                ],
                [
                    'id' => 2,
                    'text' => '新增課程',
                    'path' => '/courses/create',
                    'active' => $current=='courses/create'
                ],
                [
                    'id' => 3,
                    'text' => '狀態查詢',
                    'path' => '/statuses',
                    'active' => $current=='statuses'
                ],
                [
                    'id' => 4,
                    'text' => '錄取名單',
                    'path' => '/admissions',
                    'active' => $current=='admissions'
                ],
                [
                    'id' => 5,
                    'text' => '註冊學員名單',
                    'path' => '/course-registers',
                    'active' => $current=='course-registers'
                ],
                [
                    'id' => 6,
                    'text' => '課堂紀錄表',
                    'path' => '/lessons',
                    'active' => $current=='lessons'
                ],
                [
                    'id' => 7,
                    'text' => '課程分類',
                    'path' => '/categories',
                    'active' => $current=='categories'
                ],
            );
        }
        if($key=='settings'){
           return array(
                [
                    'id' => 1,
                    'text' => '學期設定',
                    'path' => '/terms',
                    'active' => $current=='terms'
                ],
                [
                    'id' => 2,
                    'text' => '假日設定',
                    'path' => '/holidays',
                    'active' => $current=='holidays'
                ],
                [
                    'id' => 3,
                    'text' => '開課中心',
                    'path' => '/centers',
                    'active' => $current=='centers'
                ],
                [
                    'id' => 4,
                    'text' => '教室管理',
                    'path' => '/classrooms',
                    'active' => $current=='classrooms'
                ],
               
                
            );
        }
        if($key=='discounts'|| $key=='identities'){
           return array(
                [
                    'id' => 1,
                    'text' => '折扣設定',
                    'path' => '/discounts',
                    'active' => $current=='discounts'
                ],
                [
                    'id' => 2,
                    'text' => '身分設定',
                    'path' => '/identities',
                    'active' => $current=='identities'
                ],
                
            );
        }

        if($key=='admins'){
           return array(
                [
                    'id' => 1,
                    'text' => '權限管理',
                    'path' => '/admins',
                    'active' => $current=='admins'
                ],
                [
                    'id' => 2,
                    'text' => '新增管理員',
                    'path' => '/admins/create',
                    'active' => $current=='admins/create'
                ],
                
                
            );
        }

        if($key=='notices'){
           return array(
                [
                    'id' => 1,
                    'text' => '公告管理',
                    'path' => '/notices',
                    'active' => $current=='notices'
                ],
                [
                    'id' => 2,
                    'text' => '新增公告',
                    'path' => '/notices/create',
                    'active' => $current=='notices/create'
                ],
                
                
            );
        }

        if($key=='reports'){
           return array(
                [
                    'id' => 1,
                    'text' => '課程清單',
                    'path' => '/courses-report',
                    'active' => $current=='courses-report'
                ],
               
                
                
            );
        }

        return [];
    }
}
