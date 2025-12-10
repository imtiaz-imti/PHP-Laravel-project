<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize()
    {
        return true; // allow access
    }

    public function rules()
    {
        return [
            'name'     => 'required|string|max:255',
            'username' => 'required|string|unique:users,username|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ];
    }
}

