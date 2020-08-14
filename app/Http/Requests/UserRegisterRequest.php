<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UserRegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'=> 'required|regex:/^[a-zA-Z ]*$/',
            'email' => 'required|email|unique:users',
            'username' => 'required|min:5',
            'password' => 'required|min:5',
            'country' => 'required'
        ];
    }
}
