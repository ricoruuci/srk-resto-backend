<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePassword extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'userid' => 'required|string',
            'old_password' => 'required|string|max:10',
            'new_password' => 'required|string|max:10'
        ];
    }
}
