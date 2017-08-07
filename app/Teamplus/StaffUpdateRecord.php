<?php

namespace App\Teamplus;

use App\Teamplus\TPModel;

class StaffUpdateRecord extends TPModel
{
    protected $table = 'staff_update_records';
    protected $fillable = ['name' ,'number', 'department' ,
                            'job_title','extend',
                            'email', 'password',
                            'date', 'status',
						  ];
}
