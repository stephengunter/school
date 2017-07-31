<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use App\Student;
use App\Support\Helper;

class StudentRequest extends FormRequest
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
    
   
    public function getStudentId()
    {
        $values = $this['student'];
        $id=0;        
        if(array_key_exists ( 'id' ,$values)){
            $id=(int)$values['id'];
        }  
        return $id;
    }
    

    public function getValues($updated_by)
    {
        $request=$this->get('student');
        $values=array_except($request, ['department','class']);
       
        $values= Helper::setUpdatedBy($values,$updated_by);
        return $values;
    }
    

}
