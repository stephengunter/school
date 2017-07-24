<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Photo;

class Profile extends Model {

    protected $primaryKey = 'user_id';
    
	protected $fillable = [
	   'user_id' , 'fullname', 'SID', 'gender', 'dob' ,'photo_id','title_id'
	];

	
    protected $filter = [
        'user_id', 'fullname', 'SID', 'dob', 'gender', 'created_at',
        'user.email', 'user.phone', 'user.name',
    ];

	public static function initialize()
    {
        return [            
            'fullname' => '',
            'SID' => '',
            'gender' => 1 ,
            'dob' => null ,
            'photo_id'=> null,
           
        ];
    }


	public function user() {
		return $this->belongsTo('App\User');
	}

    

    public function photo()
	{
		if(!$this->photo_id){
			return Photo::defaultProfile();
		}
		return Photo::find($this->photo_id);

	}

    public function setSIDAttribute($value) {

		$this->attributes['SID'] = strtoupper($value);
	}
	public function toOption()
    {
        $item=[ 
                 'text' => $this->fullname , 
                  'value' => $this->user_id , 
             ];

        return $item;
    }

}
