<?php

namespace App\TPSync;

use App\TPSync\BaseTPSyncModel;

class DepartmentUpdateRecord extends BaseTPSyncModel
{
    protected $table = 'department_update_records';
    protected $fillable = [ 'department_id', 'name',
						    'parent',  'is_delete',  'done'
						  ];
    public function getCode()
    {
        
        return $this->department_id;

    }          
}
