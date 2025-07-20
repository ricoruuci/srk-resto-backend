<?php

namespace App\Http\Requests\GroupMenu;

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
            'group_menu_name' => 'required|string|max:255',
        ];
    }
}
