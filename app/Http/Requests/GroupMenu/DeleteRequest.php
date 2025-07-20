<?php

namespace App\Http\Requests\GroupMenu;

use Illuminate\Foundation\Http\FormRequest;

class DeleteRequest extends FormRequest
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
