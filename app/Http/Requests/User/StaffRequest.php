<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Staff;
use App\Support\Helper;

class StaffRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
   
    public function rules()
    {
       
        return [
        ];
    }
    public function messages()
    {
        return [
         
        ];
    }
    
   
    public function getStaffId()
    {
        $values = $this['staff'];
        $id=0;        
        if(array_key_exists ( 'id' ,$values)){
            $id=(int)$values['id'];
        }  
        return $id;
    }
    

    public function getValues($updated_by)
    {
        $request=$this->get('staff');
        $values=array_except($request, ['user','department']);
       
        $values= Helper::setUpdatedBy($values,$updated_by);
        return $values;
    }
    

}
