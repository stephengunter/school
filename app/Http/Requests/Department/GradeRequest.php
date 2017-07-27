<?php

namespace App\Http\Requests\Department;

use Illuminate\Foundation\Http\FormRequest;
use App\Support\Helper;

class GradeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
   
    public function rules()
    {
        $id=$this->getEntityId();
        return [
            'grade.name' => 'required|unique:grades,name,'.$id,
          
        ];
    }
    public function messages()
    {
        return [
            'grade.name.required' => '必須填寫名稱',
            'grade.name.unique' => '名稱與現存資料重複',
         
        ];
    }
    
   
    public function getEntityId()
    {
        $values = $this['grade'];
        $id=0;        
        if(array_key_exists ( 'id' ,$values)){
            $id=(int)$values['id'];
        }  
        return $id;
    }
    

    public function getValues($updated_by)
    {
        $values=$this->get('grade');
       
        $values= Helper::setUpdatedBy($values,$updated_by);
        return $values;
    }
    

}
