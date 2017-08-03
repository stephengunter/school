<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DepartmentUpdateRecord extends Model
{
    protected $table = 'department_update_records';
    protected $fillable = [ 'department_id', 'name',
						    'parent', 'delete', 'date', 'done'
						  ];
}
