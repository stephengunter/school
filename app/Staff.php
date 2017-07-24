<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $primaryKey = 'user_id';
    
    public function user() {
		return $this->belongsTo('App\User');
	}
}
