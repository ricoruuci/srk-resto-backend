<?php

namespace App\Http\Requests\GroupMenu;

use Illuminate\Foundation\Http\FormRequest;

class GetRequestById extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'group_menu_id' => 'required|string',
        ];
    }
}
