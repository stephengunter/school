<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

use App\Photo;
use App\Role;
use Crypt;

class User extends Authenticatable
{
    use Notifiable;
    use EntrustUserTrait;

    protected $fillable = [
        'name', 'email', 'password', 'contact_info',
        'fullname', 'SID', 'gender', 'dob',
        'photo_id', 'title_id', 'removed', 'updated_by',
    ];

    protected $hidden = [
        'password', 'remember_token', 
    ];
	public function profile()
	{
		return $this->hasOne(Profile::class);
	}

    public function teacher()
	{
		return $this->hasOne(Teacher::class);
	}
	public function student()
	{
		return $this->hasOne(Student::class);
	}
    public function staff()
	{
		return $this->hasOne(Staff::class);
	}

    public function emailToken() 
	{
		return $this->hasOne(EmailToken::class);
	}
	public function passwordResetToken() 
	{
		return $this->hasOne(PasswordResetToken::class);
	}

    public function photo()
	{
		if(!$this->photo_id){
			return Photo::defaultProfile();
		}
		return Photo::find($this->photo_id);
	}

    public function setPasswordAttribute($value) 
	{
		$this->attributes['password'] = bcrypt($value);
	}
	
	
    public function setSIDAttribute($value)
	{
		$this->attributes['SID'] = Crypt::encrypt(strtoupper($value));
	}
	public function getSIDAttribute()
	{
		return Crypt::decrypt($this->attributes['SID']);
	}
	public function toOption()
    {
        $item=[ 
                 'text' => $this->fullname , 
                  'value' => $this->user_id , 
             ];

        return $item;
    }
	public function canViewBy($user)
	{
		return true;
		if($user->id==$this->id) return true;
          
	}
	public function canEditBy($user)
	{
		return true;
		if($user->id==$this->id) return true;
          
	}
	public function canDeleteBy($user)
	{
		return true;
		if(!$this->canEditBy($user)) return false;

		if(count($this->roles)){
			return false;
		}
		return true;
	}


}
