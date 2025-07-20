<?php

namespace App\Http\Requests\GroupMenu;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'group_menu_id' => 'required|string',
            'group_menu_name' => 'required|string|max:255',
        ];
    }
}
