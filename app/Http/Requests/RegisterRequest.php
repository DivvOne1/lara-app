<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * @return string[]
     */
    public function rules()
    {
        return [
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'phone' => 'required|string',
        ];
    }
    /**
     * @return true
     */
    public function authorize()
    {
        return true;
    }
}
