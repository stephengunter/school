<?php

namespace App\Teamplus;

use App\Teamplus\TPModel;

class TPDepartmentForSync extends TPModel
{
    
    protected $table = 'UserForSync';
    public $timestamps = false;

    protected $fillable =  ['LoginAccount',  'EmpID', 'Name',   'DeptCode',
                            'JobTitle', 'Email', 'Mobile', 'Extend', 'Mvpn',
                            'Status', 'Password', 'RankName' ,'UpdateTime' ,'SyncStatus' ,   'IsDelete' ,
                             'SyncUpdateTime' 
                        	];
}
