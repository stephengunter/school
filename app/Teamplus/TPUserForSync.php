<?php

namespace App\Teamplus;

use App\Teamplus\TPModel;
use Carbon\Carbon;

class TPUserForSync extends TPModel
{
    
    protected $table = 'UserForSync';
    public $timestamps = false;

    protected $fillable =  ['LoginAccount',  'EmpID', 'Name',   'DeptCode',
                            'JobTitle', 'Email', 'Mobile', 'Extend', 'Mvpn',
                            'Status', 'Password', 'RankName' ,'UpdateTime' ,'SyncStatus' ,   'IsDelete' ,
                             'SyncUpdateTime' 
                        	];
    public static function initialize()
    {
       return [
            'LoginAccount'=>'',
            'EmpID'=>'',
            'Name' => '',
            'Password' => '',
            'DeptCode' => '',
            'JobTitle' => '',
            'RankName' => '',
            'Extend'=>'',
            'Email' => '',
            'Mobile' => '',
            'Mvpn' => '',
            'Status' => 1,
            'UpdateTime' => Carbon::today(),
            'SyncStatus' => 0,
            'IsDelete' => 0,
            'SyncUpdateTime' =>''

        ];
    }                      
}
