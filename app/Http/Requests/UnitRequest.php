<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Unit;
use App\Support\Helper;

class UnitRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
   
    public function rules()
    {
        $id=$this->getUnitId();
        return [
            'unit.name' => 'required|unique:units,name,'.$id,
            'unit.code' => 'required|unique:units,code,'.$id,
          
        ];
    }
    public function messages()
    {
        return [
            'unit.name.required' => '必須填寫名稱',
            'unit.name.unique' => '名稱與現存資料重複',
            'unit.code.required' => '必須填寫代碼',
            'unit.code.unique' => '代碼與現存資料重複',
         
        ];
    }
    
   
    public function getUnitId()
    {
        $values = $this['unit'];
        $id=0;        
        if(array_key_exists ( 'id' ,$values)){
            $id=(int)$values['id'];
        }  
        return $id;
    }
    

    public function getValues($updated_by,$removed)
    {
        $request=$this->get('unit');
        $values=array_except($request, ['parentUnit']);
       
        $values= Helper::setUpdatedBy($values,$updated_by);
        return Helper::setRemoved($values,$removed);
    }
    

}
