<?php

namespace App\Http\Requests\Department;

use Illuminate\Foundation\Http\FormRequest;
use App\Support\Helper;

class ClassRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
   
    public function rules()
    {
        $id=$this->getClassId();
        return [
            'class.name' => 'required|unique:classs,name,'.$id,
            'class.code' => 'required|unique:classs,code,'.$id,
          
        ];
    }
    public function messages()
    {
        return [
            'class.name.required' => '必須填寫名稱',
            'class.name.unique' => '名稱與現存資料重複',
            'class.code.required' => '必須填寫代碼',
            'class.code.unique' => '代碼與現存資料重複',
         
        ];
    }
    
   
    public function getClassId()
    {
        $values = $this['class'];
        $id=0;        
        if(array_key_exists ( 'id' ,$values)){
            $id=(int)$values['id'];
        }  
        return $id;
    }
    

    public function getValues($updated_by,$removed)
    {
        $request=$this->get('class');
        $values=array_except($request, ['parentClass']);
       
        $values= Helper::setUpdatedBy($values,$updated_by);
        return Helper::setRemoved($values,$removed);
    }
    

}
