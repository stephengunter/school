<?php

namespace App\Http\Requests\Department;

use Illuminate\Foundation\Http\FormRequest;
use App\Department;
use App\Support\Helper;

class DepartmentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
   
    public function rules()
    {
        $id=$this->getDepartmentId();
        return [
            'department.name' => 'required|unique:departments,name,'.$id,
            'department.code' => 'required|unique:departments,code,'.$id,
          
        ];
    }
    public function messages()
    {
        return [
            'department.name.required' => '必須填寫名稱',
            'department.name.unique' => '名稱與現存資料重複',
            'department.code.required' => '必須填寫代碼',
            'department.code.unique' => '代碼與現存資料重複',
         
        ];
    }
    
   
    public function getDepartmentId()
    {
        $values = $this['department'];
        $id=0;        
        if(array_key_exists ( 'id' ,$values)){
            $id=(int)$values['id'];
        }  
        return $id;
    }
    

    public function getValues($updated_by,$removed)
    {
        $request=$this->get('department');
        $values=array_except($request, ['parentDepartment']);
       
        $values= Helper::setUpdatedBy($values,$updated_by);
        return Helper::setRemoved($values,$removed);
    }
    

}
