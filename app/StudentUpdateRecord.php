<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentUpdateRecord extends Model
{
    protected $table = 'student_update_records';
    protected $fillable = ['name' ,'number', 'department' ,
                        'email', 'password',
                         'date', 'status',
						  ];
}
