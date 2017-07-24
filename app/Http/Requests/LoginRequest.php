<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
             'username' => 'required',
             'password' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'username.required' => '請輸入教職員編號',
            'password.required' =>'請輸入密碼',
        ];
    }
}
