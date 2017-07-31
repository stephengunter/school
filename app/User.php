<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

use App\Support\FilterPaginateOrder;
use App\Support\Helper;

use App\Photo;
use App\Role;
use Crypt;

class User extends Authenticatable
{
	
    use Notifiable;
    use EntrustUserTrait;

	use FilterPaginateOrder;

    protected $hidden = [
		'password', 'remember_token'
	];

	protected $fillable = ['name', 'email', 'password', 
						    'phone', 'updated_by','contact_info'
						  ];

    protected $filter = [
        'email', 'name', 'phone', 'profile.fullname','updated_at'
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

	public static function getRules($email,$id,$role='User')
	{
		$basicRules=[];
        if($email){
            $basicRules= [
                 'user.name' => 'required|max:255',
                 'user.email'      => 'email|unique:users,email,'.$id,  
				 'profile.fullname'  => 'max:255',                
              ];
		}else{
              $basicRules= [
                 'user.name' => 'required|max:255',
                 'user.phone' => 'required|min:6|unique:users,phone,'.$id,
				 'profile.fullname'  => 'max:255',  
             ];
		}

		$extraRules=[]; 
		if($role =='User'){
			 return $basicRules;         
		}else if(in_array($role, Role::adminRoleNames())){
			$extraRules=[
			  'user.profile.fullname' => 'required|max:255',
			  'user.profile.dob' => 'required',
              'user.profile.SID' =>'required|unique:profiles,SID,'.$id .',user_id',
			  'user.phone' =>'required|min:6|unique:users,phone,'.$id,
		    ];
		}else if($role =='Teacher'){
			$extraRules=[
			  'user.profile.fullname' => 'required|max:255',
			  'user.profile.dob' => 'required',
              'user.profile.SID' =>'required|unique:profiles,SID,'.$id .',user_id',
			  'user.phone' =>'required|min:6|unique:users,phone,'.$id,
		    ];
		}else if($role =='Volunteer'){
			$extraRules=[
			  'user.profile.fullname' => 'required|max:255',
			  'user.phone' =>'required|min:6|unique:users,phone,'.$id,
		    ];
		}

		 

		 return array_merge($basicRules,$extraRules);

	}
	public static function getRuleMessages()
	{
		
         return [
				'user.name.required' => '必須填寫使用者名稱',
				
				'user.email.email' => 'Email格式不正確',
				'user.email.required' => '必須填寫Email',
				'user.email.unique' => 'Email與現存使用者重複',

				'user.phone.required' => '必須填寫手機號碼',
				'user.phone.min' => '手機號碼格式不正確',
				'user.phone.unique' => '手機號碼與現存使用者重複',

				'user.profile.fullname.required' => '必須填寫姓名',
				'user.profile.dob.required' => '必須填寫生日',
				'user.profile.SID.required' => '必須填寫身分證號',
				'user.profile.SID.unique' => '身分證號重複',
				

			];
	}
	public function defaultRole()
	{
		if(!$this->roles()->count()) return null;
		return $this->roles()->orderBy('importance','desc')->first();
		
	}


}
