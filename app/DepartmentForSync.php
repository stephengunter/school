<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DepartmentForSync extends Model
{
    protected $connection = 'sqlsrv_teamplus';
    protected $table = 'DepartmentForSync';
    public $timestamps = false;

    protected $fillable =  ['Code',  'Name', 'ParentCode',   'Description','
                             UpdateTime' ,'SyncStatus' ,   'IsDelete' ,
                             'SyncUpdateTime' 
                        	];
}
