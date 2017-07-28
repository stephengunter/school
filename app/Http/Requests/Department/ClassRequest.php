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
        $id=$this->getEntityId();
        return [
            'entity.name' => 'required|unique:classes,name,'.$id,
          
        ];
    }
    public function messages()
    {
        return [
            'entity.name.required' => '必須填寫名稱',
            'entity.name.unique' => '名稱與現存資料重複',
         
        ];
    }
    
   
    public function getEntityId()
    {
        $values = $this['entity'];
        $id=0;        
        if(array_key_exists ( 'id' ,$values)){
            $id=(int)$values['id'];
        }  
        return $id;
    }
    

    public function getValues($updated_by)
    {
        $request=$this->get('entity');
        $values=array_except($request, ['gradeOptions','grades']);
       
        $values= Helper::setUpdatedBy($values,$updated_by);
        return $values;
    }
    

}
