<?php

namespace App\Teamplus;

use App\Teamplus\TPModel;

class StudentUpdateRecord extends TPModel
{
    protected $table = 'student_update_records';
    protected $fillable = ['name' ,'number', 'department' ,
                        'email', 'password',
                         'date', 'status',
						  ];
}
