<?php

namespace App\Teamplus;

use App\Teamplus\TPModel;

class TPDepartmentForSync extends TPModel
{
    
    protected $table = 'DepartmentForSync';
    protected $primaryKey = 'SN';
    public $timestamps = false;

    protected $fillable =  ['Code',  'Name', 'ParentCode',   'Description','UpdateTime',
                              'SyncStatus' ,   'IsDelete' ,
                             'SyncUpdateTime' 
                        	];
}
