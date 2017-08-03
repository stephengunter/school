<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StaffUpdateRecord extends Model
{
    protected $table = 'staff_update_records';
    protected $fillable = ['name' ,'number', 'department' ,
                            'job_title','extend',
                            'email', 'password',
                            'date', 'status',
						  ];
}
