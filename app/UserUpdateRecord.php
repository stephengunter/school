<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserUpdateRecord extends Model
{
    protected $table = 'user_update_records';
    protected $fillable = [ 'user_id', 'role' , 'action',
						    'date', 'status',
						  ];
}
