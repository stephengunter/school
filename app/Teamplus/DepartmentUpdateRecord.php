<?php

namespace App\Teamplus;

use App\Teamplus\TPModel;

class DepartmentUpdateRecord extends TPModel
{
    protected $table = 'department_update_records';
    protected $fillable = [ 'department_id', 'name',
						    'parent', 'type', 'delete', 'date', 'done'
						  ];
    public function getCode()
    {
        if(!$this->type) return 'department_' . $this->department_id;
        return $this->type . '_' . $this->department_id;

    }          
}
