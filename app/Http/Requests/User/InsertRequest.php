<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class InsertRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'userid' => 'required|string',
            'company_id' => 'required|string',
            'group_user' => 'required|string|in:ADM,USR',
            'password' => 'nullable|string|max:10'
        ];
    }
}
